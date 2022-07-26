<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->unsigned();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('short_message')->nullable();
            $table->string('data_type')->nullable();
            $table->text('data')->nullable();
            $table->string('model_type')->nullable()->comment('the model which has been affected');
            $table->bigInteger('model_id')->unsigned()->nullable();
            $table->string('performer_model_type')->nullable()->comment('App\User or App\Admin or null => system');
            $table->bigInteger('performer_model_id')->unsigned()->nullable();
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
        Schema::dropIfExists('profile_logs');
    }
}
