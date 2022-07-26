<?php

namespace App\Listeners;

use App\Constants\GeneralConstants;
use App\Events\OfflinePaymentRegisteredEvent;
use Facades\App\Libraries\InvoiceHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OfflinePaymentRegisteredListener
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
     * @param OfflinePaymentRegisteredEvent $event
     * @return void
     */
    public function handle(OfflinePaymentRegisteredEvent $event)
    {
        $offline_payment = $event->offlinePayment;
        $invoice = InvoiceHelper::createInvoiceByCartForCurrentProfile(GeneralConstants::PAYMENT_WAY_OFFLINE, null, $offline_payment->id);
    }
}
