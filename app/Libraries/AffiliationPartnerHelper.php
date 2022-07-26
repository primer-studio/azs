<?php


namespace App\Libraries;


use App\Constants\GeneralConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AffiliationPartnerHelper
{
    public function saveUserAffiliationPartnerInDB($user, $affiliation_partner)
    {
        $user = Auth::user();
        $user->affiliation_partner_id = $affiliation_partner->id;
        $user->affiliation_partner_set_at = time();
        $user->save();
    }

    public function getMultiPartnersAffiliationInvoiceSummary($affiliation_partner_ids)
    {
        return DB::table('affiliation_invoices')
            ->select('affiliation_partner_id',
                DB::raw('SUM(commission_amount) as total_commission_amount'),
                DB::raw('COUNT(*) as count')
            )
            ->whereIn('affiliation_partner_id', $affiliation_partner_ids)
            ->where('status', '!=', GeneralConstants::AFFILIATION_INVOICE_STATUS_CHECKOUT)
            ->groupBy('affiliation_partner_id')
            ->get()->keyBy('affiliation_partner_id');
    }

    public function getSinglePartnersAffiliationInvoiceSummary($affiliation_partner_id)
    {
        $affiliation_invoices = $this->getMultiPartnersAffiliationInvoiceSummary([$affiliation_partner_id]);
        if (isset($affiliation_invoices[$affiliation_partner_id])) {
            return $affiliation_invoices[$affiliation_partner_id];
        }
        return [];
    }
}
