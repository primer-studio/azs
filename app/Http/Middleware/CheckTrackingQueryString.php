<?php

namespace App\Http\Middleware;

use App\Constants\GeneralConstants;
use Closure;
use Facades\App\Libraries\AffiliationPartnerHelper;
use Facades\App\Libraries\UserHelper;
use Illuminate\Support\Facades\Auth;

class CheckTrackingQueryString
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
        // check just GET requests
        if (strtolower($request->method()) != 'get') {
            return $next($request);
        }

        $clean_data = UserHelper::sanitizeLastQueryStringData($request->query());
        if (!$clean_data->count()) {
            return $next($request);
        }

        // if user is logged-in, save data in database
        if (Auth::check()) {
            $user = Auth::user();
            UserHelper::setLastQueryStringData($user, $clean_data, true);
        } else {
            $session_key = GeneralConstants::LAST_QUERY_STRING_DATA_SESSION_KEY;
            foreach ($clean_data as $key => $value) {
                session()->put("$session_key.$key", $value);
            }
            // if user is not logged-in, save data session, when user logs-in, we will save data in database
        }
        return $next($request);
    }
}
