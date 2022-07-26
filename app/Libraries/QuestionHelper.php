<?php


namespace App\Libraries;


use App\Question;
use App\Step;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\SettingHelper;
use Illuminate\Support\Facades\Cache;

class QuestionHelper
{
    public function getAllQuestions($just_active = true, $tree = false)
    {
        $stm = Question::orderBy('sort', 'DESC');
        if ($just_active) {
            $stm = $stm->where('status', 'active');
        }
        $questions = $stm->get();

        if ($tree && !empty($questions)) {
            return $this->_createQuestionsTree($questions);
        }
        return $questions;
    }

    protected function _createQuestionsTree($questions_list, $parent_question_id = null)
    {
        $branch = [];
        foreach ($questions_list as $item) {
            if ($item->parent_question_id == $parent_question_id) {
                $children = $this->_createQuestionsTree($questions_list, $item->id);
                $item['children'] = $children;
                $branch[$item->id] = $item;
            }
        }
        return $branch;
    }

    /**
     * @param $questions
     * @param $request
     * @param bool $skip_required_question : skip require even when the question is_required_to_receive_diet and $user_can_pay_without_answering_diet_required_questions
     * @param array $required_questions : list of questions short_names which are required even when the question not is_required_to_receive_diet and not $user_can_pay_without_answering_diet_required_questions
     * @param string $prefix
     * @return array
     */
    public function mangeRequestBasedOnQuestions($questions, $request, $skip_required_question = false, $required_questions = [], $prefix = "data")
    {
        $user_can_pay_without_answering_diet_required_questions = SettingHelper::getSettings()->user_can_pay_without_answering_diet_required_questions;
        $rules = [];
        $attributes = [];
        $data = [];
        foreach ($questions as $question) {
            $question_rules = [];
            if ($question->answer_properties->type == 'integer') {
                $question_rules[] = 'integer';
                $question_rules[] = 'min:-10000000';
                $question_rules[] = 'max:10000000';
            }
            if ($question->answer_properties->type == 'decimal') {
                $question_rules[] = 'numeric';
                $question_rules[] = 'min:-10000000';
                $question_rules[] = 'max:10000000';
                $question_rules[] = 'regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/';
            }

            if ((!$user_can_pay_without_answering_diet_required_questions && $question->is_required_to_receive_diet && !$skip_required_question) || in_array($question->short_name, $required_questions)) {
                $question_rules[] = 'required';
            }
            if ($question->answer_properties->type == 'radio') {
                $question_rules[] = "in:" . implode(",", collect($question->answer_properties->options)->map(function ($input) {
                        return $input->value;
                    })->toArray());
            }
            if ($question->answer_properties->type == 'checkbox') {
                $rules["$prefix." . $question->short_name . ".*"] = "in:" . implode(",", collect($question->answer_properties->options)->map(function ($input) {
                        return $input->value;
                    })->toArray());
                $question_rules[] = 'array';
            }
            if ($question->short_name == "favorite_food") {

            }
            // add title as attribute
            $attributes["$prefix." . $question->short_name] = $question->title;
            $rules["$prefix." . $question->short_name] = $question_rules;
            $data[$question->short_name] = $request->input("$prefix." . $question->short_name);
        }

        return [
            'rules' => $rules,
            'attributes' => $attributes,
            'data' => $data,
        ];
    }

    /**
     * get all questions with their related step and diet
     * @param string $search
     * @param bool $just_active
     * @return mixed
     */
    public function getAllQuestionsWithStepsAndDiets($search = '', $just_active = true)
    {
        $stm = Question::orderBy('sort', 'DESC');
        $stm->with(['steps' => function ($q) {
            $q->with('diet')->get();
        }]);
        if ($just_active) {
            $stm = $stm->where('status', 'active');
        }
        if (!empty($search)) {
            $stm->where(function ($query) use ($search) {
                $query->where("title", "like", "%$search%");
                $query->orWhere("short_name", "like", "%$search%");
            });
        }
        return $stm->get();
    }

    public function getQuestionsByShortName($short_names)
    {
        return Question::whereIn('short_name', $short_names)->get()->keyBy('short_name');
    }
}
