<?php

use App\Constants\GeneralConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AddDefaultRoleToOldUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $default_role = Role::where(['guard_name' => 'web', 'name' => GeneralConstants::DEFAULT_USER_ROLE])->first();
        $users = \App\User::all();
        foreach ($users as $user) {
            try {
                $user->roles()->attach($default_role);
            } catch (Exception $exception) {

            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
