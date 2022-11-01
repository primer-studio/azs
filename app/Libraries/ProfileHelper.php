<?php


namespace App\Libraries;


use App\Events\ProfileUpdatedEvent;
use App\Profile;
use App\Question;
use Facades\App\Libraries\DietHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;

class ProfileHelper
{

    public $requiredProfileKeys = [
        'name',
        'gender',
        'date_of_birth',
    ];

    /**
     * get profiles table columns
     * @return mixed
     */
    public function getProfilesTableColumns()
    {
        return Schema::getColumnListing('profiles');
    }

    /**
     * returns false if even one of $requiredProfileKeys will be empty
     * @param int $profile_id
     * @return bool
     * @throws \Exception
     */
    public function checkRequiredQuestions($profile_id = 0)
    {
        // TODO[back-end]: use cache Redis
        $profile = $profile_id ? $this->getProfile($profile_id) : $this->getCurrentProfile();
        if (empty($profile)) {
            // TODO[back-end]: change this Exception
            throw new \Exception('profile is empty!');
        }

        foreach ($this->requiredProfileKeys as $key) {
            if (!isset($profile->{$key})) {
                return false;
            }
            if (empty($profile->{$key})) {
                return false;
            }
        }

        return true;
    }

    public function getProfile($profile_id)
    {
        return Profile::findOrFail($profile_id);
    }

    /**
     * get the profile's data: the current profile (stored in cookie) or first profile related the logged-in user
     * @param boolean $reset_session
     * @return mixed
     */
    public function getCurrentProfile($reset_session = false)
    {
        // TODO[back-end]: add cache
        // TODO[back-end]: check security (session fixation - $request->session()->regenerate())
        $current_profile_id = $this->_getCurrentProfileId();
        // if current_profile_id exists in session and reset_session is not passed, we can use cookie to get the current profile id
        if (!$reset_session && !empty($current_profile_id)) {
            $profile = $this->getProfile($current_profile_id);
        }

        // session is empty or it has a deleted profile id
        if (empty($profile)) {
            // get logged-in user's first profile
            $profile = Profile::where(['user_id' => Auth::user()->id])->first();
            // save data in session for the next requests
            $this->setCurrentProfileId($profile->id);
        }

        return $profile;
    }

    public function DoesUserSetRealName($profile_id = 0)
    {
        $profile = $profile_id ? $this->getProfile($profile_id) : $this->getCurrentProfile();
        return (!str_contains($profile->name, 'کاربر'));
    }

    /**
     * encrypt, the save current_profile_id in session
     * @param $profile_id
     */
    public function setCurrentProfileId($profile_id)
    {
        session(['current_profile_id' => encrypt($profile_id)]);
    }

    /**
     * get and decrypt current_profile_id from session
     * @return bool|mixed
     */
    protected function _getCurrentProfileId()
    {
        $encrypted_current_profile_id = session('current_profile_id');
        if (!empty($encrypted_current_profile_id)) {
            return decrypt($encrypted_current_profile_id);
        }
        return false;
    }

    public function updateCurrrentProfile($data)
    {
        return $this->updateProfileById($this->getCurrentProfile()->id, $data);
    }

    public function updateProfileById($profile_id, $data)
    {
        $update_array = [];
        foreach ($data as $key => $value) {
            if (($key == 'data')) {
                if (!is_array($value)) {
                    return false;
                }
                foreach ($value as $json_key => $json_value) {
                    $update_array["data->$json_key"] = $json_value;
                }
            } else {
                $update_array[$key] = $value;
            }
        }
        $profile = Profile::findOrFail($profile_id);
        // save this action's log for the profile log
        event(new ProfileUpdatedEvent($profile, 'array', $data));
        return $profile->update($update_array);
    }

    public function currentProfileAnsweredDietRequiredQuestions($diet, $period)
    {
        $profile = $this->getCurrentProfile();
        return $this->profileAnsweredDietRequiredQuestions($profile, $diet, $period);
    }

    public function profileAnsweredDietRequiredQuestions($profile, $diet, $period)
    {
        if (!isset($diet->period_questions[$period])) {
            // TODO[fix-label]: fix label/message
            hiReport('the given period did not set for $diet->period_questions, diet: ' . json_encode($diet) . ', period: ' . $period);
            return false;
        }
        $pending_questions = [];
        $profile_data_null = [];
        foreach ($diet->period_active_required_questions[$period] as $question) {
            if (!(isset($profile->data->{$question->short_name}) && !is_null($profile->data->{$question->short_name}))) {
                $pending_questions[$question->short_name] = $question;
                $profile_data_null[$question->short_name] = null;
            }
        }

        if (!empty($profile_data_null)) {
            // set null value for these questions
            $this->updateProfileById($profile->id, [
                'data' => $profile_data_null
            ]);
        }

        return collect($pending_questions);
    }
}
