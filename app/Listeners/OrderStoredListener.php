<?php

namespace App\Listeners;

use App\Events\OrderStoredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderStoredListener
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
     * @param  OrderStoredEvent  $event
     * @return void
     */
    public function handle(OrderStoredEvent $event)
    {
        //
    }
}
