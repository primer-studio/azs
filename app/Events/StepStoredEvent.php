<?php

namespace App\Events;

use App\Step;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StepStoredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Step
     */
    public $step;

    /**
     * Create a new event instance.
     *
     * @param Step $step
     */
    public function __construct(Step $step)
    {
        $this->step = $step;
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
