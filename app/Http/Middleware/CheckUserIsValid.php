<?php

namespace App\Http\Middleware;

use Closure;
use Facades\App\Libraries\ProfileHelper;
use Illuminate\Support\Facades\Auth;

class CheckUserIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $params = [];

        if (empty($user->mobile_number_verified_at)) {
            $message = __('user.you_should_verify_your_mobile_number');
        }

        if ($user->is_temp) {
            $message = __('user.you_should_enter_your_mobile_number');
            $params = [
                'mtp' => urlencode(encrypt(json_encode([
                    'profile_id_to_move' => ProfileHelper::getCurrentProfile()->id,
                    'temp_user_id' => $user->id,
                ])))
            ];
        }

        if (!empty($message)) {
            $request->session()->flash('CheckUserIsValid', $message);
            // redirect user after login (redirect()->intended())
            $request->session()->put('url.intended', $request->getRequestUri());
            return redirect(route('login', $params));
        }

        return $next($request);
    }
}
