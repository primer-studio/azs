<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_super')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        \App\Admin::create([
            "name" => 'Ali Karimi',
            "username" => 'alikarimi',
            "email" => 'alikarimi_azshabe69@gmail.com',
            "password" => Illuminate\Support\Facades\Hash::make('$Ali9696KaRimi@!!'),
        ]);


        \App\Admin::create([
            "name" => 'Soheil Yousefi',
            "username" => 'soheilyou',
            "email" => 'soheilyou@gmail.com',
            "password" => Illuminate\Support\Facades\Hash::make('$Az@sus1688!!'),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
