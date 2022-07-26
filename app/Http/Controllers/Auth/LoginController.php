<?php

namespace App\Http\Controllers\Auth;

use App\Constants\ErrorResponse;
use App\Constants\GeneralConstants;
use App\Events\UserLoginEvent;
use App\Http\Controllers\Controller;
use App\Libraries\TempProfileHelper;
use App\Rules\ValidMobileNumber;
use App\User;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\UserHelper;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $allowedUsername = [
        'mobile_number',
    ];

    protected $_username = 'mobile_number';

    /**
     * dynamic username
     * @return string
     */
    public function username()
    {
        return $this->_username;
    }

    public $verificationCodeExpiresAfterSeconds = 60;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except(['logout', 'adminLogout', 'showLoginForm', 'showConfirmLogout', 'verificationCodeLogin', 'setVerificationCodeLogin', 'login']);
        $this->middleware('guest:admin')->except(['adminLogout', 'showConfirmLogout']);
    }

    /**
     * set login verification code then send SMS
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setVerificationCodeLogin(Request $request, TempProfileHelper $tempProfileHelper)
    {
        // sanitizeMobileNumber: convert persian digits to english digits, add 0 to the first of mobile number (if it is required)
        UserHelper::sanitizeMobileNumber($request);

        // TODO[back-end]: add limitation to send sms
        // the regex check for mobile_number has been set in middleware
        $rules = [
            'mobile_number' => ['required', new ValidMobileNumber()],
        ];

        if ($request->has('register')) {
            $rules['name'] = ['required', 'max:255'];
            $register = true;
        }

        // TODO[back-end]: validate fields, this is temporary
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return setErrorResponse($validator->messages());
            } else {
                return redirect()
                    ->back()
                    ->withErrors($validator->messages())
                    ->withInput();
            }
        }

        $user = UserHelper::getUserByMobileNumber($request->only('mobile_number'));

        /**
         * we decided to send verification code in registration process (if user already exists) and do not show  'mobile_number_already_exists' error
         * if (!empty($user) && !empty($register)) {
         * return setErrorResponse(__('general.mobile_number_already_exists'), 200);
         * }
         */

        // user does not exist, check setting
        if (empty($user)) {
            // update temp user if he is already logged-in
            if ($tempProfileHelper->canCompleteCurrentTempProfile()) {
                $user = UserHelper::updateCurrentUser($request->only('mobile_number'));
                ProfileHelper::updateCurrrentProfile($request->only('name'));
            } else {
                // create new user (if the request is for register or it is for login but user not found)
                $user = UserHelper::createUser($request->only(['mobile_number', 'name']));
            }
        }

        if (!empty($user)) {
            $user = UserHelper::sendVerificationCode($user);
            // redirect to enter code page
            // TODO[fix-label]: fix label/message, set proper response
            if ($request->expectsJson()) {
                return successfulDataResponse([], 'code generated');
            } else {
                // flash data in session
                session()->flash(GeneralConstants::VERIFICATION_CODE_GENERATED_FOR_MOBILE_NUMBER_SESSION_KEY, $user->mobile_number);
                return redirect()->back()->with('success', __('auth.code_generated'));
            }
        }

        // TODO[fix-label]: fix label/message
        // TODO[back-end]: set proper response
        // show error
        if ($request->expectsJson()) {
            return setErrorResponse(__('general.wrong_account_data'));
        } else {
            return redirect()
                ->back()
                ->withErrors(__('general.wrong_account_data'))
                ->withInput();
        }
    }

    /**
     * overwrite login method
     * @param Request $request
     * @param TempProfileHelper $tempProfileHelper
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(Request $request, TempProfileHelper $tempProfileHelper)
    {
        /*
         * "mtp" is abbreviation of "move temp profile"
         * if this parameter presents, it means user is temp and he is coming from "CheckUserIsValid" middleware
         * and we should check the decoded data in "mtp" and if it is correct, move the current profile to the signed-in account
         */
        $mtp = '';
        if ($request->has('mtp')) {
            $mtp = $request->input('mtp');
        }

        if ($tempProfileHelper->shouldBeRedirected()) {
            return $tempProfileHelper->redirectToHome();
        }

        return view('auth.login', compact('mtp'));
    }

    /**
     * @param Request $request
     * @param TempProfileHelper $tempProfileHelper
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verificationCodeLogin(Request $request, TempProfileHelper $tempProfileHelper)
    {
        // sanitizeMobileNumber: convert persian digits to english digits, add 0 to the first of mobile number (if it is required)
        UserHelper::sanitizeMobileNumber($request);
        // sanitizeVerificationCode: convert persian digits to english digits
        UserHelper::sanitizeVerificationCode($request);

        if ($tempProfileHelper->shouldBeRedirected()) {
            // TODO[back-end]: this is temp, we should decide about this after speaking, for now we log out the current user
            Auth::logout();
            /*
            if ($request->expectsJson()) {
                return setSuccessfulResponse(RouteServiceProvider::HOME, false);
            } else {
                return redirect(RouteServiceProvider::HOME);
            }
            */
        }

        // change $this->_username to change output of $this->username() which will be used in ThrottlesLogins
        $this->_username = 'mobile_number';

        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required', new ValidMobileNumber()],
            'verification_code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return setErrorResponse($validator->messages());
            } else {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        // flash data in session
        session()->flash(GeneralConstants::VERIFICATION_CODE_GENERATED_FOR_MOBILE_NUMBER_SESSION_KEY, $request->input('mobile_number'));

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $user_obj = User::where($request->only('mobile_number', 'verification_code'));
        $user = $user_obj->first();

        if (!empty($user)) {

            // TODO[fix-label]: fix label/message
            // check the code has been expired?
            if (($user->verification_code_set_at + $this->verificationCodeExpiresAfterSeconds) < time()) {
                if ($request->expectsJson()) {
                    return setErrorResponse(__('general.wrong_verification_code'));
                } else {
                    return redirect()->back()->withErrors(__('general.wrong_verification_code'))->withInput();
                }
            }

            // verify mobile number
            if (empty($user->mobile_number_verified_at)) {
                $user = UserHelper::updateUser($user, [
                    'is_temp' => false,
                    'mobile_number_verified_at' => time()
                ]);
            }

            // move current profile if it is possible
            $tempProfileHelper->moveTempProfileIfPossible($user);

            // login user
            Auth::loginUsingId($user->id, true);
            event(new UserLoginEvent($user));

            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            // redirect if there is not any intended URL
            $redirect = $this->getRedirectAfterLoginUrl();
            $redirect_url = session()->pull('url.intended', $redirect);
            if ($request->expectsJson()) {
                return setSuccessfulResponse($redirect_url, false);
            } else {
                return redirect($redirect);
            }

        }
        $this->incrementLoginAttempts($request);

        // TODO[fix-label]: fix label/message
        // show error
        if ($request->expectsJson()) {
            return setErrorResponse(__('general.wrong_verification_code'));
        } else {
            return redirect()->back()->withErrors(__('general.wrong_verification_code'))->withInput();
        }
    }

    /**
     * Soheilyou_overrode
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        // TODO[back-end]: load this from settings ,this is temporary
        $request->validate([
            'mobile_number' => 'required|string',
        ]);
    }

    /**
     * Soheilyou_overrode
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $allowed_data = $this->allowedUsername;
        $allowed_data[] = "password";
        return $request->only($allowed_data);
    }

    /**
     * show admin login form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdminLoginForm()
    {
        return view('panel.auth.login');
    }

    /**
     * login admin
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminLogin(Request $request)
    {
        $this->_username = 'email';
        // TODO[back-end]: add username and mobile number too ,this is temporary
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $validator->validate();

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // successful login
            $request->session()->regenerate();
			// logout other devices
            Auth::guard('admin')->logoutOtherDevices($request->password);
            $this->clearLoginAttempts($request);
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }
        $this->incrementLoginAttempts($request);
        // TODO[back-end]: make this better
        return redirect()->back()->withErrors(__('wrong authentication input'));
    }

    /**
     * logoute admin
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect(route('show-admin-login-form'));
    }

    /**
     * 2 user types can not be logged-in at a same time in a same browser (admins and users)
     * when a user type is logged-in and the user tries to login as the another user type in the same
     * browser, he should logs out from the other one
     * this method shows him a confirm button to inform him and prevent Sabotages
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showConfirmLogout($type)
    {
        return view("auth.show-confirm-logout", compact('type'));
    }

    /**
     * (overrode by soheilyou) Redirect the user after determining they are locked out.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $error_message = __('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]);

        if ($request->expectsJson()) {
            return setErrorResponse($error_message);
        } else {
            return redirect()->back()->withErrors($error_message)->withInput();
        }
    }

    public function getRedirectAfterLoginUrl()
    {
        // by default redirect to all diets list
        $redirect = route('dashboard.diets'); // default
        $profile = ProfileHelper::getCurrentProfile(true);
        $orders = $profile->orders;
        if ($orders->count()) {
            // if profile has order, redirect to orders list
            $redirect = route('dashboard.orders.index');
            $last_completed_order = $profile->orders()->where([
                'status' => GeneralConstants::ORDER_STATUS_COMPLETED
            ])->first();
            if (!empty($last_completed_order)) {
                // if user has an order which is completed, redirect to that
                $redirect = route('dashboard.orders.index');
            }
        }
        return $redirect;
    }
}
