<?php

namespace App\Http\Middleware;

use Closure;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\SettingHelper;

class CheckProfileRequiredData
{
    /**
     * check all required data has been entered by the user
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check settings: user_can_skip_profile_questions?
        if (!SettingHelper::getSettings()->user_can_skip_profile_questions) {
            // returns false if even one of $requiredProfileKeys will be empty
            if (!ProfileHelper::checkRequiredQuestions()) {
                // redirect user to answer the required questions
                // TODO[fix-label]: fix label/message
                $request->session()->flash('check_profile_required_data_middleware_message', __('general.check_profile_required_data_middleware_message'));
                // 'redirect_to' parameter will be added in session , and in the next processes we know that what was the requested URL and we can redirect user
                session()->push('after_update_profile_redirect_to', $request->getRequestUri());
                return redirect(route('dashboard.my-profiles.edit', ['profile' => ProfileHelper::getCurrentProfile()->id]));
            }
        }
        return $next($request);
    }
}
