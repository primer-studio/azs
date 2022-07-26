<?php

namespace App\Http\Middleware;

use Closure;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\SettingHelper;
use Facades\App\Libraries\UserHelper;

class CheckUserMustPayWithoutAnsweringDietRequiredQuestions
{
    /**
     * You should use this middleware only for steps routes
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check settings: user_must_pay_without_answering_diet_required_questions?
        if (SettingHelper::getSettings()->user_must_pay_without_answering_diet_required_questions) {
            $pay_url = route('dashboard.proforma-invoice', UserHelper::getLastQueryStringData());
            if ($request->getRequestUri() !== $pay_url) {
                // TODO[fix-label]: fix label/message: this message can be optional
                $request->session()->flash('CheckUserMustPayWithoutAnsweringDietRequiredQuestions', 'Before the requested operation you should pay');
                // 'redirect_to' parameter will be added in query string, and in the next processes we know that what was the requested URL and we can redirect user
                return redirect($pay_url);
            }
        }
        return $next($request);
    }
}
