<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitBasicRolesPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $get_ordinary_diets_permission = Permission::create(['name' => 'get_ordinary_diets']);
        $basic_user_role = Role::create(['name' => \App\Constants\GeneralConstants::DEFAULT_USER_ROLE]);
        $basic_user_role->givePermissionTo($get_ordinary_diets_permission);
        $trainer_role = Role::create(['name' => 'مربی باشگاه']);
    }

    /**
     * @throws Exception
     */
    public function down()
    {
        $role = Role::findByName(\App\Constants\GeneralConstants::DEFAULT_USER_ROLE);
        $role->delete();

        $role = Role::findByName('مربی باشگاه');
        $role->delete();

        $permission = Permission::findByName('get_ordinary_diets');
        $permission->delete();
    }
}
