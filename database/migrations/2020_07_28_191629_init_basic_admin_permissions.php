<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class InitBasicAdminPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create([
            'name' => 'change_settings',
            'title' => 'تغییر تنظیمات',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_admins',
            'title' => 'تغییر اطلاعات ادمین ها',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_permissions',
            'title' => 'تغییر دسترسی ادمین ها',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'add_diet',
            'title' => 'افزودن رژیم',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_diet',
            'title' => 'تغییر رژیم',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'see_profiles_data',
            'title' => 'مشاهده اطلاعات پروفایل ها',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_profiles_data',
            'title' => 'تغییر اطلاعات پروفایل ها',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'see_mobile_number',
            'title' => 'مشاهده شماره موبایل',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_invoice',
            'title' => 'تغییر صورت حساب ها',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_order',
            'title' => 'تغییر سفارش ها',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_affiliation_partner',
            'title' => 'تغییر همکاران فروش',
            'guard_name' => 'admin',
        ]);
        Permission::create([
            'name' => 'change_contact_us_request',
            'title' => 'تغییر درخواست های تماس با ما',
            'guard_name' => 'admin',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::whereIn('name', [
            'change_settings',
            'change_admins',
            'change_permissions',
            'add_diet',
            'change_diet',
            'see_profiles_data',
            'change_profiles_data',
            'see_mobile_number',
            'change_invoice',
            'change_order',
            'change_affiliation_partner',
            'change_contact_us_request'
        ])->where('guard_name', 'admin')->delete();
    }
}
