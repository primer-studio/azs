<?php


namespace App\Libraries;

use App\Step;

class StepHelper
{
    public function getAllSteps($just_active = true)
    {
        $stm = Step::orderBy('sort', 'DESC');
        if ($just_active) {
            $stm = $stm->where('status', 'active');
        }
        return $stm->get();
    }

    public function getStepWithQuestions($step_id)
    {
        $step = Step::with('questions')->findOrFail($step_id);
        return $step;
    }
}
