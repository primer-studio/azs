<?php

namespace App\Listeners;

use App\Constants\ProfileLogConstants;
use App\Events\InvoiceStoredEvent;
use Facades\App\Libraries\ProfileLogHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvoiceStoredListener
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
     * @param  InvoiceStoredEvent  $event
     * @return void
     */
    public function handle(InvoiceStoredEvent $event)
    {
        $invoice = $event->invoice;
        $profile_id = $event->profile_id;
        $data_type = $event->data_type;
        $data = $event->data;
        ProfileLogHelper::add($profile_id, ProfileLogConstants::TYPE_CREATED, 'App\Invoice', $invoice->id, $data_type, $data);
    }
}
