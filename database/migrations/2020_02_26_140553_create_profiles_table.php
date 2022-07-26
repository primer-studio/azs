<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->integer('height')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('last_diet')->nullable();
            $table->string('blood_type', 10)->nullable();
            $table->text('illness_history')->nullable();
            $table->text('favorite_foods')->nullable();
            $table->text('disgusting_foods')->nullable();
            $table->text('prohibited_foods')->nullable();
            $table->bigInteger('date_of_birth')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->string('city')->nullable();
            $table->json('data')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
