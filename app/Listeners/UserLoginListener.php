<?php

namespace App\Listeners;

use App\AffiliationPartner;
use App\Constants\GeneralConstants;
use App\Events\UserLoginEvent;
use Facades\App\Libraries\UserHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Facades\App\Libraries\AffiliationPartnerHelper;

class UserLoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {
        $user = $event->user;

        # =========================  affiliation partner - start ========================= #
        // check for affiliation_partner_id
        $affiliation_partner_id = session()->pull(GeneralConstants::AFFILIATION_PARTNER_ID_SESSION_KEY);
        if (!empty($affiliation_partner_id)) {
            // if an affiliation partner with this user name exists and it is active
            $affiliation_partner = AffiliationPartner::where([
                'id' => $affiliation_partner_id,
                'status' => 'active'
            ])->first();

            if (!empty($affiliation_partner)) {
                AffiliationPartnerHelper::saveUserAffiliationPartnerInDB($user, $affiliation_partner);
            }
        }
        # =========================  affiliation partner -  end  ========================= #

        # =========================  check tracking query string - start ========================= #
        $query_string_data = session()->pull(GeneralConstants::LAST_QUERY_STRING_DATA_SESSION_KEY);
        if (!empty($query_string_data)) {
            UserHelper::setLastQueryStringData($user, $query_string_data);
        }
        # =========================  check tracking query string -  end  ========================= #
    }
}
