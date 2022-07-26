<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceStoredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $profile_id;
    public $data;
    public $data_type;
    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param $invoice
     * @param $profile_id
     * @param null $data_type
     * @param null $data
     */
    public function __construct($invoice, $profile_id, $data_type = null, $data = null)
    {
        $this->invoice = $invoice;
        $this->profile_id = $profile_id;
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