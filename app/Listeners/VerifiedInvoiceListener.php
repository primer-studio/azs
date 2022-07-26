<?php

namespace App\Listeners;

use App\AffiliationInvoice;
use App\Constants\GeneralConstants;
use App\Constants\ProfileLogConstants;
use App\Diet;
use App\Events\OfflinePaymentVerifiedEvent;
use App\Events\VerifiedInvoiceEvent;
use Facades\App\Libraries\CartHelper;
use Facades\App\Libraries\ProfileHelper;
use Facades\App\Libraries\InvoiceHelper;
use Facades\App\Libraries\ProfileLogHelper;

class VerifiedInvoiceListener
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
     * @param VerifiedInvoiceEvent $event
     * @return void
     */
    public function handle(VerifiedInvoiceEvent $event)
    {
        $invoice = $event->invoice;
        // double check invoice is paid?
        if ($invoice->status != GeneralConstants::TRANSACTION_VERIFIED) {
            return setErrorResponse(__('invoice.invoice_is_not_paid'));
        }

        // if payment_way is offline, send notification to aware user
        if ($invoice->payment_way == GeneralConstants::PAYMENT_WAY_OFFLINE && !empty($invoice->offline_payment_id)) {
            $offline_payment = $invoice->offlinePayment;
            // verify offline payment too
            $offline_payment->update([
                'is_verified' => true,
                'verified_at' => time(),
            ]);
            // fire event to send notifications and etc
            event(new OfflinePaymentVerifiedEvent($offline_payment));
        }

        $profile = ProfileHelper::getProfile($invoice->profile_id);
        $user = $profile->user;
        $affiliation_partner = $user->affiliationPartner;
        $invoice_items = $invoice->invoiceItems()->get();
        $diet_ids = $invoice_items->pluck('diet_id')->unique();
        $diets = Diet::find($diet_ids)->keyBy('id');
        foreach ($invoice_items as $invoice_item) {
            if (empty($diets[$invoice_item->diet_id])) {
                hiReport("diet not found in VerifiedInvoiceListener, invoice_item: " . json_encode($invoice_item));
                continue;
            }
            /**
             * this method checks for pending questions (and it will fire event(new PendingInvoiceItemEvent($invoice_item)) if you set $fire_pending_invoice_item_event true and there is any pending question)
             * and if everything is ok, it will set order for the invoice item then fire event(new OrderCreatedEvent($order))
             */
            InvoiceHelper::setInvoiceItemOrder($invoice_item, $profile, $diets[$invoice_item->diet_id]);

            /**
             * the invoice is verified, so lets remove the related cart item
             */
            CartHelper::removeDietByDetails($invoice_item->diet_id, $invoice_item->diet_period, $profile->id);
        }

        # =========================  affiliation commission - start ========================= #
        if (!empty($affiliation_partner) && $affiliation_partner->status == 'active') {
            $commission_amount = is_null($affiliation_partner->commission_rate) ? 0 : (($affiliation_partner->commission_rate / 100) * $invoice->total_amount_without_vat);
            $affiliation_invoice = AffiliationInvoice::create([
                'affiliation_partner_id' => $affiliation_partner->id,
                'invoice_id' => $invoice->id,
                'profile_id' => $profile->id,
                'total_amount' => $invoice->total_amount,
                'total_amount_without_vat' => $invoice->total_amount_without_vat,
                'commission_rate' => $affiliation_partner->commission_rate,
                'commission_amount' => $commission_amount,
                'status' => GeneralConstants::AFFILIATION_INVOICE_STATUS_CREATED,
            ]);
        }
        # =========================  affiliation commission -  end  ========================= #

        # =========================  profile log - start ========================= #
        $profile_log_short_message = __('general.change_status_to', ['status' => __('invoice.TRANSACTION_VERIFIED')]);
        ProfileLogHelper::add($profile->id, ProfileLogConstants::TYPE_UPDATED, 'App\Invoice', $invoice->id, 'array', $invoice, $profile_log_short_message);
        # =========================  profile log -  end  ========================= #
    }
}
