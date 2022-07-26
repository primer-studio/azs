<?php

namespace App\Http\Middleware;

use App\Events\UserLoginEvent;
use Closure;
use Facades\App\Libraries\SettingHelper;
use Facades\App\Libraries\UserHelper;
use Illuminate\Support\Facades\Auth;

class TempUser
{
    /**
     * this middleware checks settings to find out register_temp_user is true?
     * if it is true, we create a temporary user (and a profile), then we login user automatically! (is_temp = true)
     * these users must complete their account info, otherwise their accounts will be deleted automatically (by cron job or similar things) after a delay
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // check setting: can we register temporary users?
            if (SettingHelper::getSettings()->register_temp_user) {
                // create new user with profile
                $user = UserHelper::createUser([
                    'username' => 'temp_' . time(),
                    'is_temp' => true
                ]);
                Auth::loginUsingId($user->id, true);
                event(new UserLoginEvent($user));
            }
        }

        return $next($request);
    }
}
