<?php

namespace App\Listeners;

use App\Events\DietStoredEvent;
use Facades\App\Libraries\CacheHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DietStoredListener
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
     * @param  DietStoredEvent  $event
     * @return void
     */
    public function handle(DietStoredEvent $event)
    {
        CacheHelper::removeDietCache($event->diet->id);
    }
}
