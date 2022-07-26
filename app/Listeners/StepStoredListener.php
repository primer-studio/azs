<?php

namespace App\Listeners;

use App\Events\StepStoredEvent;
use Facades\App\Libraries\CacheHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StepStoredListener
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
     * @param  StepStoredEvent  $event
     * @return void
     */
    public function handle(StepStoredEvent $event)
    {
        CacheHelper::removeDietCache($event->step->diet_id);
    }
}
