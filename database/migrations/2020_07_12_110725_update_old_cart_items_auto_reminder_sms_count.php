<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOldCartItemsAutoReminderSmsCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add 2 in auto_reminder_sms_count	to not send sms again for these users
        \App\CartItem::where(
            'auto_reminder_sms_sent_at', "<", (Carbon::now()->addDay(-4)->timestamp)
        )->update([
            'auto_reminder_sms_count' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
