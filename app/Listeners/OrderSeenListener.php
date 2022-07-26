<?php

namespace App\Listeners;

use App\Events\OrderSeenEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderSeenListener
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
     * @param  OrderSeenEvent  $event
     * @return void
     */
    public function handle(OrderSeenEvent $event)
    {
        // TODO[back-end]: mange this event
    }
}
