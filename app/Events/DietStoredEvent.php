<?php

namespace App\Events;

use App\Diet;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DietStoredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $diet;

    /**
     * Create a new event instance.
     *
     * @param $diet
     */
    public function __construct(Diet $diet)
    {
        //
        $this->diet = $diet;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
