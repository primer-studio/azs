<?php

namespace App\Http\Controllers\Panel;

use App\Diet;
use App\Events\QuestionStoredEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question as QuestionResource;
use App\Step;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\QuestionHelper;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    // TODO[back-end]: validate fields, this is temporary
    // TODO[back-end]: add attributes in lang
    public $rules = [
        'title' => 'string',
        'short_name' => 'regex:/^[a-z_]+$/',
        'answer_properties' => 'array',
    ];

    // TODO[fix-label]: fix label/message
    // set dynamic attributes titles
    public $attributes = [
        'answer_properties.options' => "answer's options"
    ];

    public $answerOptionsAreAvailable = false;

    public $saveRequestInputs = [
        'parent_question_id',
        'available_if_parent_answer_operator',
        'available_if_parent_answer_value',
        'short_name',
        'title',
        'description',
        'period',
        'status',
        'image',
        'sort',
    ];

    public function getAllQuestions(Request $request)
    {
        $questions = QuestionHelper::getAllQuestionsWithStepsAndDiets($request->input('search_input'), false);
        return successfulDataResponse([
            'questions' => $questions
        ]);
    }

    public function create()
    {
        $all_questions = QuestionHelper::getAllQuestions();
        return view('panel.main')->nest('content', 'panel.questions.set', compact('all_questions'));
    }

    public function cleanRequest(Request $request)
    {
        if ($request->has('answer_properties.type')) {
            // if answer properties type is 'checkbox' or 'radio', answer_properties.options must be required and for each option, title and value are required too
            if (in_array($request->input('answer_properties.type'), ['checkbox', 'radio'])) {
                $this->answerOptionsAreAvailable = true;
                $this->rules['answer_properties.options'] = 'required|array';
                $this->rules['answer_properties.options.*.title'] = 'required';
                $this->rules['answer_properties.options.*.value'] = 'required';
                $this->rules['answer_properties.options.*.sort'] = 'required';
                if ($request->has('answer_properties.options')) {
                    // set dynamic attributes for each option's title and value (to show in validation errors)
                    foreach ($request->input('answer_properties.options') as $option_key => $option) {
                        // TODO[fix-label]:  fix label/message
                        $this->attributes["answer_properties.options.$option_key.title"] = "option $option_key title";
                        $this->attributes["answer_properties.options.$option_key.value"] = "option $option_key value";
                        $this->attributes["answer_properties.options.$option_key.sort"] = "option $option_key sort";
                    }
                }
            }
        }

        if ($request->has('parent_question_id') && !is_null($request->input('parent_question_id'))) {
            $this->rules['parent_question_id'] = ['exists:questions,id'];
        } else {
            $request->merge(['available_if_parent_answer_operator' => null]);
            $request->merge(['available_if_parent_answer_value' => null]);
        }

        // if available_if_parent_answer_operator is not 'none', then 'available_if_parent_answer_value' must be required
        if ($request->has('available_if_parent_answer_operator') && $request->input('available_if_parent_answer_operator') != 'none' && isset($this->rules['parent_question_id'])) {
            $this->rules['available_if_parent_answer_value'] = 'required';
            // if available_if_parent_answer_operator is 'greater_than' or 'less_than', then  available_if_parent_answer_value must be numeric
            if (in_array($request->input('available_if_parent_answer_operator'), ['greater_than', 'less_than'])) {
                $this->rules['available_if_parent_answer_value'] .= '|numeric';
            }
        } else {
            // set null 'available_if_parent_answer_operator' and 'available_if_parent_answer_value' if  'available_if_parent_answer_operator' is not set or is 'none'
            $request->merge(['available_if_parent_answer_value' => null]);
        }
        return $request;
    }

    public function getSaveData(Request $request)
    {
        $data = $request->only($this->saveRequestInputs);
        $data['is_required_to_receive_diet'] = $request->has('is_required_to_receive_diet');
        if (isset($data['short_name'])) {
            $data['short_name'] = strtolower($data['short_name']);
        }

        // clean answer_properties! get only type and options
        if ($request->has('answer_properties')) {
            $answer_properties = collect($request->input('answer_properties'));
            $clean_answer_properties = $answer_properties->only('type');
            // clean options! get only title and value
            if ($this->answerOptionsAreAvailable) {
                $answer_options = $answer_properties['options'];
                $clean_answer_options = [];
                foreach ($answer_options as $answer_property) {
                    $clean_answer_options[] = collect($answer_property)->only(['title', 'value', 'sort'])->toArray();
                }
                // sort options
                $clean_answer_properties['options'] = collect($clean_answer_options)->sortBy('sort')->values()->all();
            }
            $data['answer_properties'] = json_encode($clean_answer_properties);
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('sort', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.questions.list', compact('questions'));
    }

    public function tidyList()
    {
        // get all diets with their steps and questions
        $diets = DietHelper::getAllDiets(false);
        return view('panel.main')->nest('content', 'panel.questions.tidy-list', compact('diets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $all_questions = QuestionHelper::getAllQuestions();
        return view('panel.main')->nest('content', 'panel.questions.set', compact('all_questions', 'question'));
    }

    /**
     * @param $question_id
     * @param Request $request
     * @return QuestionResource|\Illuminate\Http\JsonResponse
     */
    public function update($question_id, Request $request)
    {
        $this->cleanRequest($request);
        // TODO[back-end]: validate fields, this is temporary
        $validator = Validator::make($request->all(), $this->rules, [], $this->attributes);

        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $this->getSaveData($request);
        $question = Question::findOrFail($question_id);
        $question->update($data);
        event(new QuestionStoredEvent($question));
        return setSuccessfulResponse(route('panel.questions.edit', ['question' => $question->id]));
    }

    /**
     * @param Request $request
     * @return QuestionResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->cleanRequest($request);
        $rules = $this->rules;
        $rules['title'] .= "|required";
        $rules['short_name'] .= "|required|unique:questions";
        $rules['answer_properties'] .= "|required";
        // TODO[back-end]: validate fields, this is temporary
        $validator = Validator::make($request->all(), $rules, [], $this->attributes);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }

        $data = $this->getSaveData($request);
        $question = Question::create($data);
        event(new QuestionStoredEvent($question));
        return setSuccessfulResponse(route('panel.questions.edit', ['question' => $question->id]));
    }
}
