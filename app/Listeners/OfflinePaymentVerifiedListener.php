<?php

namespace App\Listeners;

use App\Events\OfflinePaymentVerifiedEvent;
use App\Notifications\OfflinePaymentVerified;
use Facades\App\Libraries\InvoiceHelper;
use Facades\App\Libraries\SmsHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OfflinePaymentVerifiedListener
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
     * @param OfflinePaymentVerifiedEvent $event
     * @return void
     */
    public function handle(OfflinePaymentVerifiedEvent $event)
    {
        $offline_payment = $event->offlinePayment;
        $profile = $offline_payment->profile;
        $user = $profile->user;
        $offline_payment_type = InvoiceHelper::trnaslateOfflinePaymentStatus($offline_payment);
        $profile->notify(new OfflinePaymentVerified($offline_payment));
        // send SMS if user have mobile number
        if (!empty($user->mobile_number)) {
            SmsHelper::sendOfflinePaymentVerified($user->mobile_number, $profile->name, $offline_payment_type);
        }
    }
}
