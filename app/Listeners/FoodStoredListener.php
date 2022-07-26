<?php

namespace App\Listeners;

use App\Events\FoodStoredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FoodStoredListener
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
     * @param  FoodStoredEvent  $event
     * @return void
     */
    public function handle(FoodStoredEvent $event)
    {
        //
    }
}
