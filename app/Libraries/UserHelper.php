<?php


namespace App\Libraries;


use App\Constants\GeneralConstants;
use App\Events\ProfileStoredEvent;
use App\Http\Controllers\ThirdParty\SmsController;
use App\Jobs\sendUserMobileVerificationCode;
use App\User;
use Facades\App\Libraries\SmsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserHelper
{

    public $allowedLastQueryStringParameters = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    public $forbiddenLastQueryStringParameters = [
        'gateway_id',
        'invoice_id',
    ];

    /**
     * create new user
     * @param array $data
     * @param bool $create_profile
     * @return mixed
     */
    public function createUser(array $data, $create_profile = true)
    {
        // get just each field of these collection which isset
        $data_collection = collect($data)->only([
            'email',
            'is_temp',
            'mobile_number',
            'username',
            'password',
        ]);

        // password must be hashed
        if ($data_collection->has('password')) {
            $data_collection['password'] = Hash::make($data_collection['password']);
        }

        $user = User::create($data_collection->toArray());
        if ($create_profile) {
            $profile_data = collect($data)->only([
                'name',
                'gender',
                'date_of_birth',
                'province_id',
                'city',
                'data',
            ]);
            if (empty($profile_data['name'])) {
                $profile_data['name'] = __('general.temp_profile_name', ['code' => $user->id]);
            }
            $profile = $user->profiles()->create($profile_data->toArray());
            // data for profile log
            $profile_log_data = collect($data)->except('password')->toArray();
            // save this action's log for the profile log
            event(new ProfileStoredEvent($profile, 'array', $profile_log_data));
        }
        // add default role to user
        $default_role = Role::where(['guard_name' => 'web', 'name' => GeneralConstants::DEFAULT_USER_ROLE])->first();
        $user->roles()->attach($default_role);
        return $user;
    }

    public function sendVerificationCodeCurrentUser()
    {
        return $this->sendVerificationCode(Auth::user());
    }

    public function sendVerificationCode(User $user)
    {
        $data = [];
        $data['verification_code'] = generateRandomCode();
        if (env('APP_ENV') != 'production') {
            $data['verification_code'] = 123;
        }
        $data['verification_code_set_at'] = time();
        $user = $this->updateUser($user, $data);
//        SmsHelper::sendVerificationCode($user->mobile_number, $data['verification_code']);
        $adapter = New SmsController();
        $adapter->SendVerificationCode($user->mobile_number, $data['verification_code']);
        return $user;
    }

    public function updateCurrentUser($data)
    {
        return $this->updateUser(Auth::user(), $data);
    }

    public function updateUser($user, $data)
    {
        $update_data = collect($data)->except('password');
        $user->update($update_data->toArray());
        return $user;
    }

    public function getUserByMobileNumber($mobile_number)
    {
        return User::where($mobile_number)->first();
    }

    /**
     * sanitizeMobileNumber: convert persian digits to english digits, add 0 to the first of mobile number (if it is required)
     * @param $request
     */
    public function sanitizeMobileNumber(&$request)
    {
        if ($request->has('mobile_number')) {
            $mobile_number = trim($request->input('mobile_number'));
            $mobile_number = toEnglishDigit($mobile_number);
            if (preg_match('/^9[0-9]{9}$/', $mobile_number)) {
                $mobile_number = 0 . $mobile_number;
            }
            $request->merge(['mobile_number' => $mobile_number]);
        }
    }

    /**
     * convert persian digits to english digits
     * @param $request
     */
    public function sanitizeVerificationCode(&$request)
    {
        if ($request->has('verification_code')) {
            $verification_code = trim($request->input('verification_code'));
            $verification_code = toEnglishDigit($verification_code);
            $request->merge(['verification_code' => $verification_code]);
        }
    }

    /**
     * sanitize query string to just save allowed parameters and allow characters
     * @param $input_array
     * @return \Illuminate\Support\Collection
     */
    public function sanitizeLastQueryStringData($input_array)
    {
        $data = collect($input_array)->only($this->allowedLastQueryStringParameters)->map(function ($item) {
            return preg_replace("/[^A-Za-z0-9_-]/", "", $item);
        });

        foreach ($this->forbiddenLastQueryStringParameters as $key) {
            if (isset($data[$key])) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * set allowed data in json column
     * @param $user
     * @param $query_string_data
     * @param bool $data_is_sanitized
     * @return mixed
     */
    public function setLastQueryStringData($user, $query_string_data, $data_is_sanitized = false)
    {
        $clean_query_string_data = $data_is_sanitized ? $query_string_data : $this->sanitizeLastQueryStringData($query_string_data);
        if (empty($clean_query_string_data)) {
            return $user;
        }
        $update_array = [];
        foreach ($clean_query_string_data as $key => $value) {
            $update_array["last_query_string_data->" . $key] = $value;
        }
        $user->update($update_array);

        return $user;
    }

    /**
     * somewhere in our app we are going to put last_query_string_data in URL again
     * because we are going to track user in google analytics
     * @return array
     */
    public function getLastQueryStringData()
    {
        $last_query_string_data = Auth::user()->last_query_string_data;
        if (empty($last_query_string_data)) {
            return [];
        }
        return collect($last_query_string_data)->toArray();
    }
}
