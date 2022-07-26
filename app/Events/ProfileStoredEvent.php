<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProfileStoredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $profile;
    /**
     * @var null
     */
    public $data;
    /**
     * @var null
     */
    public $data_type;

    /**
     * Create a new event instance.
     *
     * @param $profile
     * @param null $data_type
     * @param null $data
     */
    public function __construct($profile, $data_type = null, $data = null)
    {
        //
        $this->profile = $profile;
        $this->data = $data;
        $this->data_type = $data_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
    }
}
