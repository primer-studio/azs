<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('set null');
            $table->bigInteger('invoice_item_id')->unsigned()->unique()->nullable();
            $table->foreign('invoice_item_id')->references('id')->on('invoice_items')->onDelete('set null');
            $table->string('status', 100)->default('created');
            $table->boolean('seen')->default(false);
            $table->bigInteger('start_date')->nullable();
            $table->integer('duration_in_day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
