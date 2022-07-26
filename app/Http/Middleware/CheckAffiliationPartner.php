<?php

namespace App\Http\Middleware;

use App\AffiliationPartner;
use App\Constants\GeneralConstants;
use Facades\App\Libraries\AffiliationPartnerHelper;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckAffiliationPartner
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
        // if affiliation_partner exists in URL query string
        if ($request->has('affiliation_partner')) {
            $affiliation_partner_username = $request->input('affiliation_partner');

            $validator = Validator::make($request->all(), [
                'affiliation_partner' => 'string|max:255'
            ]);

            if ($validator->fails()) {
                return $next($request);
            }
            // if an affiliation partner with this user name exists and it is active
            $affiliation_partner = AffiliationPartner::where([
                'username' => $affiliation_partner_username,
                'status' => 'active'
            ])->first();

            if (empty($affiliation_partner)) {
                return $next($request);
            }

            // if user is logged-in, save data in database
            if (Auth::check()) {
                $user = Auth::user();
                AffiliationPartnerHelper::saveUserAffiliationPartnerInDB($user, $affiliation_partner);
            } else {
                // if user is not logged-in, save data session, when user logs-in, we will save data in database
                session()->put(GeneralConstants::AFFILIATION_PARTNER_ID_SESSION_KEY, $affiliation_partner->id);
            }
        }
        return $next($request);
    }
}
