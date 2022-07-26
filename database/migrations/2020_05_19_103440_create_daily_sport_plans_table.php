<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySportPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_sport_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('day')->index();
            $table->bigInteger('sport_id')->unsigned()->nullable();
            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->string('before_sport_comment')->nullable()->comment('admin can add custom comment which will appear before sport');
            $table->string('after_sport_comment')->nullable()->comment('admin can add custom comment which will appear after sport');
            $table->decimal('amount_in_unit')->nullable();
            $table->string('section')->comment('each day has 1 or more sections');
            $table->integer('total_calories');
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
        Schema::dropIfExists('daily_sport_plans');
    }
}
