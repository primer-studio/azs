<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersCountToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->renameColumn('reminder_sms_sent_at', 'auto_reminder_sms_sent_at');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->bigInteger('manual_reminder_sms_sent_at')->after('auto_reminder_sms_sent_at')->nullable();
            $table->integer('auto_reminder_sms_count')->after('manual_reminder_sms_sent_at')->default(0);
            $table->integer('manual_reminder_sms_count')->after('auto_reminder_sms_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->renameColumn('auto_reminder_sms_sent_at', 'reminder_sms_sent_at');
            $table->dropColumn('manual_reminder_sms_sent_at');
            $table->dropColumn('auto_reminder_sms_count');
            $table->dropColumn('manual_reminder_sms_count');
        });
    }
}
