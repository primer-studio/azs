<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyRecommendationPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_recommendation_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('day')->index();
            $table->bigInteger('recommendation_id')->unsigned()->nullable();
            $table->foreign('recommendation_id')->references('id')->on('recommendations')->onDelete('cascade');
            $table->string('before_recommendation_comment')->nullable()->comment('admin can add custom comment which will appear before recommendation');
            $table->string('after_recommendation_comment')->nullable()->comment('admin can add custom comment which will appear after recommendation');
            $table->string('section')->comment('each meal has 1 or more sections');
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
        Schema::dropIfExists('daily_recommendation_plans');
    }
}
