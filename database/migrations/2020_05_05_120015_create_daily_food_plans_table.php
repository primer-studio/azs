<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyFoodPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_food_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('day')->index();
            $table->bigInteger('food_id')->unsigned()->nullable();
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->string('before_food_comment')->nullable()->comment('admin can add custom comment which will appear before food');
            $table->string('after_food_comment')->nullable()->comment('admin can add custom comment which will appear after food');
            $table->decimal('amount_in_unit')->nullable();
            $table->string('meal')->comment('breakfast, snack1, lunch, snack2, dinner, snack3');
            $table->string('section')->comment('each meal has 1 or more sections');
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
        Schema::dropIfExists('daily_food_plans');
    }
}
