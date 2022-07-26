<?php

namespace App\Listeners;

use App\Constants\ProfileLogConstants;
use App\Events\ProfileUpdatedEvent;
use App\Events\ProfileUpdateRequestEvent;
use Facades\App\Libraries\ProfileLogHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProfileUpdateRequestListener
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

    public function handle(ProfileUpdateRequestEvent $event)
    {
        $profile = $event->profile;
        $data_type = $event->data_type;
        $data = $event->data;
        ProfileLogHelper::add($profile->id, ProfileLogConstants::TYPE_UPDATE_REQUESTED, 'App\Profile', $profile->id, $data_type, $data);
    }
}
