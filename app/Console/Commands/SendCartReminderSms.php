<?php

namespace App\Console\Commands;

use App\CartItem;
use App\Jobs\SendCartSmsReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendCartReminderSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendCartReminderSms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SendCartReminderSms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // cart items which was updated more then 1 hour ago
        // auto_reminder_sms_sent_at is null or auto_reminder_sms_sent_at was more than 3 years ago
        $cart_items = CartItem::with('profile.user')->where(
            'updated_at', "<", (Carbon::now()->addHour(-1)->timestamp)
        )
            ->where(
                'auto_reminder_sms_count', "<", 2
            )
            ->where(
                function ($query) {
                    $query->where(function ($sub) {
                        $sub->where(
                            'auto_reminder_sms_sent_at', "<", (Carbon::now()->addDay(-3)->timestamp)
                        )->where(
                            'auto_reminder_sms_sent_at', "!=", null
                        );
                    });

                    $query->orwhere(function ($sub) {
                        $sub->where(
                            'auto_reminder_sms_sent_at', "=", null
                        );
                    });
                }
            )
            ->orderBy('created_at', 'ASC')->get()->reject(function ($cart_item) {
                // and user mobile number exists and verified
                return (empty($cart_item->profile->user->mobile_number) || empty($cart_item->profile->user->mobile_number_verified_at));
            });
        $cart_items_grouped = $cart_items->groupBy('profile_id');
        foreach ($cart_items_grouped as $group) {
            $profile = $group->first()->profile;
            $mobile_number = $profile->user->mobile_number;
            SendCartSmsReminder::dispatch($mobile_number, $profile, false);
        }
    }
}
