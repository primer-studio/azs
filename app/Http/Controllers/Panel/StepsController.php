<?php

namespace App\Http\Controllers\Panel;

use App\Events\DietCacheResetEvent;
use App\Events\StepStoredEvent;
use App\Http\Controllers\Controller;
use App\Step;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\StepHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Resources\Step as StepResource;

class StepsController extends Controller
{
    public $saveRequestInputs = [
        'diet_id',
        'title',
        'description',
        'period',
        'status',
        'image',
        'sort'
    ];

    public function __construct()
    {
        $this->middleware(['can:change_diet']);
    }

    public function create()
    {
        $all_diets = DietHelper::getAllDiets();
        return view('panel.main')->nest('content', 'panel.steps.set', compact('all_diets'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $steps = Step::orderBy('sort', 'DESC')->paginate(10);
        return view('panel.main')->nest('content', 'panel.steps.list', compact('steps'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $step = StepHelper::getStepWithQuestions($id);
        $selected_questions_ids = $step->questions->map(function ($question) {
            return $question->id;
        });
        $all_diets = DietHelper::getAllDiets(false);
        return view('panel.main')->nest('content', 'panel.steps.set', compact('step', 'all_diets', 'selected_questions_ids'));
    }

    public function syncQuestions($request, $step)
    {
        if ($request->has('questions_ids')) {
            $sorted_array = [];
            foreach (json_decode($request->input('questions_ids'), true) as $index => $question_id) {
                $sorted_array[$question_id] = ['sort' => $index];
            }
            $step->questions()->sync($sorted_array);
        }
    }

    /**
     * @param $step_id
     * @param Request $request
     * @return StepResource|\Illuminate\Http\JsonResponse
     */
    public function update($step_id, Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $validator = Validator::make($request->all(), [
            'diet_id' => 'exists:diets,id',
            'title' => 'string',
            'period' => 'numeric',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $step = Step::findOrFail($step_id);
        $step->update($data);
        $this->syncQuestions($request, $step);
        event(new StepStoredEvent($step));
        return setSuccessfulResponse(route('panel.steps.edit', ['step' => $step->id]));
    }

    /**
     * @param Request $request
     * @return StepResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // TODO[back-end]: validate fields, this is temporary
        $validator = Validator::make($request->all(), [
            'diet_id' => 'required|exists:diets,id',
            'title' => 'required|string',
            'period' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $data = $request->only($this->saveRequestInputs);
        $step = Step::create($data);
        $this->syncQuestions($request, $step);
        event(new StepStoredEvent($step));
        return setSuccessfulResponse(route('panel.steps.edit', ['step' => $step->id]));
    }

}
