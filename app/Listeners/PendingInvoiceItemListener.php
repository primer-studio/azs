<?php

namespace App\Listeners;

use App\Events\PendingInvoiceItemEvent;
use App\Mail\PendingInvoiceItemMail;
use App\Notifications\PendingInvoiceItem;
use Facades\App\Libraries\QuestionHelper;
use Facades\App\Libraries\SmsHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PendingInvoiceItemListener
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
     * @param PendingInvoiceItemEvent $event
     * @return void
     */
    public function handle(PendingInvoiceItemEvent $event)
    {
        $invoice_item = $event->invoiceItem;
        $invoice = $invoice_item->invoice;
        $diet = $invoice_item->diet;
        $profile = $invoice->profile;
        $user = $profile->user;

        $profile->notify(new PendingInvoiceItem($invoice_item));
        // send SMS if user have mobile number
        if (!empty($user->mobile_number)) {
            SmsHelper::sendPendingInvoiceItem($user->mobile_number, $profile->name, $diet->title);
        }
    }
}
