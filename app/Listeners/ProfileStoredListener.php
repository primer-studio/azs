<?php

namespace App\Listeners;

use App\Constants\ProfileLogConstants;
use App\Events\ProfileStoredEvent;
use Facades\App\Libraries\ProfileLogHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProfileStoredListener
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
     * @param ProfileStoredEvent $event
     * @return void
     */
    public function handle(ProfileStoredEvent $event)
    {
        $profile = $event->profile;
        $data_type = $event->data_type;
        $data = $event->data;
        ProfileLogHelper::add($profile->id, ProfileLogConstants::TYPE_CREATED, 'App\Profile', $profile->id, $data_type, $data);
    }
}
