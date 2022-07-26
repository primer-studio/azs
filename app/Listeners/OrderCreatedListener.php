<?php

namespace App\Listeners;

use App\Constants\ProfileLogConstants;
use App\Events\OrderCreatedEvent;
use App\Notifications\OrderCreated;
use App\Notifications\PendingInvoiceItem;
use Facades\App\Libraries\ProfileLogHelper;
use Facades\App\Libraries\SmsHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener
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
     * @param OrderCreatedEvent $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        $order = $event->order;
        $profile = $order->profile;
        $user = $profile->user;
        $diet = $order->invoiceItem->diet;
        $profile->notify(new OrderCreated($order));
        // send SMS if user have mobile number
        if (!empty($user->mobile_number)) {
            SmsHelper::sendOrderCreated($user->mobile_number, $profile->name, $diet->title);
        }

        # =========================  profile log - start ========================= #
        ProfileLogHelper::add($profile->id, ProfileLogConstants::TYPE_CREATED, 'App\Order', $order->id, 'array', $order);
        # =========================  profile log -  end  ========================= #
    }
}
