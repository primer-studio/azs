<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable()->unique();
            $table->string('mobile_number')->nullable()->unique();
            $table->bigInteger('mobile_number_verified_at')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('verification_code')->nullable();
            $table->bigInteger('verification_code_set_at')->nullable();
            $table->string("affiliate_token", 200)->nullable();;
            $table->boolean("is_temp")->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();;
            $table->bigInteger("presented_by_user_id")->unsigned()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
