<?php

namespace App\Listeners;

use App\Constants\ProfileLogConstants;
use App\Events\CartItemUpdatedEvent;
use Facades\App\Libraries\ProfileLogHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartItemUpdatedListener
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
     * @param  CartItemUpdatedEvent  $event
     * @return void
     */
    public function handle(CartItemUpdatedEvent $event)
    {
        $cart_item = $event->cart_item;
        $profile_id = $event->profile_id;
        $data_type = $event->data_type;
        $data = $event->data;
        ProfileLogHelper::add($profile_id, ProfileLogConstants::TYPE_UPDATED, 'App\CartItem', $cart_item->id, $data_type, $data);
    }
}
