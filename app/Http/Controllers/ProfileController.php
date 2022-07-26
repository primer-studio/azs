<?php

namespace App\Http\Controllers;

use App\Constants\ProfileLogConstants;
use App\Events\ProfileStoredEvent;
use App\Events\ProfileUpdatedEvent;
use App\Profile;
use App\Province;
use Facades\App\Libraries\ProfileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Facades\App\Libraries\QuestionHelper;

class ProfileController extends Controller
{
    // TODO[back-end]: add the remaining fields
    public $saveRequestInputs = [
        'name',
        'gender',
        'date_of_birth',
        'height',
        'marital_status',
        'last_diet',
        'blood_type',
        'illness_history',
        'favorite_foods',
        'disgusting_foods',
        'prohibited_foods',
        'province_id',
        'city',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    # =========================  dashboard - start ========================= #

    /**
     * this method gets profile only if it is for the logged-in user
     * @param $profile_id
     * @return mixed
     */
    protected function getProfile($profile_id)
    {
        $profile = Profile::where(['id' => $profile_id, 'user_id' => Auth::user()->id])->first();
        if (empty($profile)) {
            abort(404);
        }
        return $profile;
    }

    public function myProfiles()
    {
        $profiles = Profile::where(['user_id' => Auth::user()->id])->get();
        $current_profile = ProfileHelper::getCurrentProfile();
        return view('dashboard.main')->nest('content', 'dashboard.profile.my-profiles', compact('profiles', 'current_profile'));
    }

    public function currentProfile()
    {
        $current_profile = ProfileHelper::getCurrentProfile();
        return $this->editProfile($current_profile->id);
    }

    public function editProfile($profile_id)
    {
        $provinces = Province::orderBy('sort', 'ASC')->get();
        $profile = $this->getProfile($profile_id);
        $questions = QuestionHelper::getAllQuestions(true, true);
        return view('dashboard.main')->nest('content', 'dashboard.profile.edit-profile', compact('profile', 'questions', 'provinces'));
    }

    public function updateProfile($profile_id, Request $request)
    {
        // get jalali year, month, day in an array and stick them together and override request
        generateJalaliDateFromArray($request, 'date_of_birth');
        $questions = QuestionHelper::getAllQuestions(true);
        $manged = QuestionHelper::mangeRequestBasedOnQuestions($questions, $request);

        $rules = $manged['rules'];
        $attributes = $manged['attributes'];
        $questions_data = $manged['data'];

        // append rules for basic information
        $rules['name'] = 'string|max:255';
        $rules['gender'] = 'string|in:male,female';

        if ($request->has('date_of_birth') && !empty($request->input('date_of_birth'))) {
            $rules['date_of_birth'] = 'jdate';
        }

        if ($request->has('height') && !empty($request->input('height'))) {
            $rules['height'] = 'numeric|max:300|min:5';
        }
        $rules['marital_status'] = 'in:single,married';
        $rules['last_diet'] = 'max:255';
        $rules['blood_type'] = 'max:10';
        $rules['illness_history'] = 'max:500';
        $rules['favorite_foods'] = 'max:500';
        $rules['disgusting_foods'] = 'max:500';
        $rules['prohibited_foods'] = 'max:500';
        $rules['province_id'] = 'exists:provinces,id';
        $rules['city'] = 'max:255';

        $validator = Validator::make($request->all(), $rules, [], $attributes);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }

        $data = $request->only($this->saveRequestInputs);
        $data['date_of_birth'] = !empty($data['date_of_birth']) ? jdateToTimestamp($data['date_of_birth']) : null;
        $data['data'] = $questions_data;
        $profile = $this->getProfile($profile_id);

        $profile->update($data);
        // save this action's log for the profile log
        event(new ProfileUpdatedEvent($profile, 'array', $data));
        $redirect_url = route('dashboard.my-profiles.edit', ['profile' => $profile_id]);

        // if redirect_to exits in the session, we prefer to redirect user to it (CheckProfileRequiredData middleware can add this parameter)
        $after_update_profile_redirect_to = session()->pull('after_update_profile_redirect_to');
        if (!empty($after_update_profile_redirect_to)) {
            $redirect_url = $after_update_profile_redirect_to;
        }

        return setSuccessfulResponse($redirect_url);
    }

    public function setCurrentProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile' => 'required'
        ]);
        if ($validator->fails()) {
            return setErrorResponse($validator->messages());
        }
        $profile_id = decrypt($request->input('profile'));
        // check the selected profile exits and it is for the logged-in user
        if (!Profile::where(['user_id' => Auth::user()->id, 'id' => $profile_id])->exists()) {
            return setErrorResponse(__('general.there_was_a_problem'));
        }
        ProfileHelper::setCurrentProfileId($profile_id);
        return setSuccessfulResponse(route('dashboard.my-profiles.index'));
    }

    /**
     * create new profile from dashboard
     */
    public function store()
    {
        $user = Auth::user();
        $profile = $user->profiles()->create();
        $profile->name = __('general.temp_profile_name', ['code' => $profile->id]);
        $profile->save();
        // save this action's log for the profile log
        event(new ProfileStoredEvent($profile));
        $redirect_url = route('dashboard.my-profiles.edit', ['profile' => $profile->id]);
        return setSuccessfulResponse($redirect_url);
    }
    # =========================  dashboard -  end  ========================= #
}
