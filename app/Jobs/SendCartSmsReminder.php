<?php

namespace App\Jobs;

use App\CartItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Facades\App\Libraries\SmsHelper;

class SendCartSmsReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $mobile_number;
    private $profile;
    private $isManual;

    /**
     * Create a new job instance.
     *
     * @param $mobile_number
     * @param $profile
     * @param bool $is_manual
     */
    public function __construct($mobile_number, $profile, $is_manual = false)
    {
        $this->mobile_number = $mobile_number;
        $this->profile = $profile;
        $this->isManual = $is_manual;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsHelper::sendCartReminder($this->mobile_number, $this->profile->name);
        $cart_items = CartItem::where(['profile_id' => $this->profile->id])->get();
        foreach ($cart_items as $cart_item) {
            $sent_at_column = $this->isManual ? 'manual_reminder_sms_sent_at' : 'auto_reminder_sms_sent_at';
            $count_column = $this->isManual ? 'manual_reminder_sms_count' : 'auto_reminder_sms_count';
            $cart_item->increment($count_column);
            $cart_item->{$sent_at_column} = time();
            $cart_item->save();
        }
    }
}

