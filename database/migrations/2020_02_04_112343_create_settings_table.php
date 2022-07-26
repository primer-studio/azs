<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_title')->nullable();
            $table->string('site_short_title')->nullable();
            $table->boolean('user_can_answer_without_login')->default(false);
            $table->boolean('user_can_skip_profile_questions')->default(false);
            $table->boolean('user_can_pay_without_registration')->default(false);
            $table->integer('vat_percentage')->default(0);
            $table->boolean('vat_visibility_is_invoice')->nullable();
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
        Schema::dropIfExists('settings');
    }

}
