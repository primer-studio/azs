<?php

namespace App\Listeners;

use App\Constants\ProfileLogConstants;
use App\Events\OrderCompletedEvent;
use App\Notifications\OrderCompleted;
use Facades\App\Libraries\ProfileLogHelper;
use Facades\App\Libraries\SmsHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCompletedListener
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
     * @param OrderCompletedEvent $event
     * @return void
     */
    public function handle(OrderCompletedEvent $event)
    {
        $order = $event->order;
        $profile = $order->profile;
        $user = $profile->user;
        $diet = $order->invoiceItem->diet;
        $profile->notify(new OrderCompleted($order));
        // send SMS if user have mobile number
        if (!empty($user->mobile_number)) {
            SmsHelper::sendOrderCompleted($user->mobile_number, $profile->name, $diet->title);
        }

        # =========================  profile log - start ========================= #
        $profile_log_short_message = __("general.change_status_to", ['status' => __('order.ORDER_STATUS_COMPLETED')]);
        ProfileLogHelper::add($profile->id, ProfileLogConstants::TYPE_UPDATED, 'App\Order', $order->id, 'array', $order, $profile_log_short_message);
        # =========================  profile log -  end  ========================= #
    }
}
