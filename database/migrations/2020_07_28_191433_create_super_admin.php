<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Admin::where(['email' => 'alikarimi_azshabe69@gmail.com'])->update(
            [
                'is_super' => 1
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Admin::where(['is_super' => 1])->update(
            [
                'is_super' => 0
            ]
        );
    }
}
