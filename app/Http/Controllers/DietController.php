<?php

namespace App\Http\Controllers;

use App\Exceptions\PermissionDenied;
use App\Exceptions\StopExeption;
use Facades\App\Libraries\CartHelper;
use Facades\App\Libraries\QuestionHelper;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\DietHelper;
use Facades\App\Libraries\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class DietController extends Controller
{
    public function __construct()
    {
        $this->middleware('tempUser')->only(['showStep', 'show']);
        $this->middleware('checkProfileRequiredData')->except('index');
    }

    # =========================  dashboard - start ========================= #
    public function index()
    {
        $diets = DietHelper::getAllDiets();
        return view('dashboard.main')->nest('content', 'dashboard.diets.list', compact('diets'));
    }

    public function show($slug)
    {
        $diet = DietHelper::getDietBySlug($slug);
        // check permission
        $this->checkPermission($diet);
        return view('dashboard.main')->nest('content', 'dashboard.diets.show', compact('diet'));
    }


    public function showStep($diet_slug, $period, $step_number)
    {
        $diet = DietHelper::getDietBySlug($diet_slug);
        // check permission
        $this->checkPermission($diet);
        $profile = ProfileHelper::getCurrentProfile();
        if (
            empty($diet->active_periods_steps_questions[$period][$step_number - 1]) || // period exists?
            $diet->status != 'active' || // diet is active?
            $diet->active_periods_steps_questions[$period][$step_number - 1]->status != 'active' // period is active?
        ) {
            abort(404);
        }

        // put data in cart
        CartHelper::attachDietToProfile($diet->id, $period, $step_number, false, $profile->id, route('dashboard.diets.show-step', ['slug' => $diet_slug, "period" => $period, 'step_number' => $step_number], false));
        $current_step = $diet->active_periods_steps_questions[$period][$step_number - 1];
        $all_steps = $diet->active_periods_steps_questions[$period];
        return view('dashboard.main')->nest('content', 'dashboard.diets.show-step', compact('current_step', 'diet', 'period', 'step_number', 'profile', 'all_steps'));
    }

    public function saveStepData($diet_slug, $period, $step_number, Request $request)
    {
        $diet = DietHelper::getDietBySlug($diet_slug);
        // check permission
        $this->checkPermission($diet);
        if (empty($diet->active_periods_steps_questions[$period][$step_number - 1])) {
            abort(404);
        }

        $current_step = $diet->active_periods_steps_questions[$period][$step_number - 1];

        // define next step
        if (!empty($diet->active_periods_steps_questions[$period][$step_number])) {
            $next_step_url = route('dashboard.diets.show-step', ['slug' => $diet_slug, "period" => $period, 'step_number' => $step_number + 1]);
        } else {
            // if it is the last step, the next step is payment
            $next_step_url = route('dashboard.proforma-invoice', UserHelper::getLastQueryStringData());
        }

        $manged = QuestionHelper::mangeRequestBasedOnQuestions($current_step->questions, $request);

        $rules = $manged['rules'];
        $attributes = $manged['attributes'];
        $data = $manged['data'];

        $validator = Validator::make($request->all(), $rules, [], $attributes);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }

        if (ProfileHelper::updateCurrrentProfile(['data' => $data])) {
            return setSuccessfulResponse($next_step_url, false);
        }
        return setErrorResponse([
            __("general.problem_while_saving")
        ]);
    }

    public function checkPermission($diet)
    {
        if (!DietHelper::canGetDiet(Auth::user(), $diet)) {
            throw new PermissionDenied();
        }
    }
    # =========================  dashboard -  end  ========================= #
}
