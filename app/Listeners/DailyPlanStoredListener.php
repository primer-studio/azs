<?php

namespace App\Listeners;

use App\Events\DailyPlanStoredEvent;
use Facades\App\Libraries\CacheHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DailyPlanStoredListener
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
     * @param  DailyPlanStoredEvent  $event
     * @return void
     */
    public function handle(DailyPlanStoredEvent $event)
    {
        $order = $event->order;
        // remove order cache
        CacheHelper::removeOrderCache($order->id);
    }
}
