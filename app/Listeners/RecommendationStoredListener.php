<?php

namespace App\Listeners;

use App\Events\RecommendationStoredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecommendationStoredListener
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
     * @param  RecommendationStoredEvent  $event
     * @return void
     */
    public function handle(RecommendationStoredEvent $event)
    {
        //
    }
}
