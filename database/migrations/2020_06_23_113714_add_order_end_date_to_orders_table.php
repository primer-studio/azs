<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderEndDateToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('end_date')->nullable()->after('start_date');
        });

        $orders = \App\Order::where( 'start_date', ">", 0)->get();
        foreach ($orders as $order) {
            $end_date = \Carbon\Carbon::createFromTimestamp($order->start_date)->addDay($order->duration_in_day - 1)->timestamp;
            $order->update([
                'end_date' => $end_date
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('end_date');
        });
    }
}
