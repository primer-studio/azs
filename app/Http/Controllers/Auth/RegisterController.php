<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Facades\App\Libraries\UserHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // TODO[back-end]: change this determine the required fields by settings data
    public $register_by_mobile_number = true;

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        // disable registration
        abort(404);
        die();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // TODO[back-end]: change this determine the required fields by settings data, this is temporary
        $registration_required_data = [
            'name',
            'mobile_number'
        ];

        $validation_array = [];

        // add email rules
        if (in_array("email", $registration_required_data)) {
            $validation_array['mobile_number'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        // add mobile number rules
        if ($this->register_by_mobile_number or in_array("mobile_number", $registration_required_data)) {
            $validation_array['mobile_number'] = ['required', 'string', 'max:255', 'unique:users'];
        }

        // add username rules
        if (in_array("username", $registration_required_data)) {
            $validation_array['username'] = ['required', 'string', 'max:255', 'unique:users'];
        }

        // add name rules
        if (in_array("name", $registration_required_data)) {
            $validation_array['name'] = ['required', 'string', 'max:255'];
        }

        return Validator::make($data, $validation_array);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return UserHelper::createUser($data);
    }


    /**
     * Soheilyou_overrode
     * Handle a registration request for the application.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
