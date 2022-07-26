<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('owner_email')->nullable()->after('site_short_title');
            $table->text('email_cc')->nullable()->after('owner_email');
            $table->text('email_bcc')->nullable()->after('email_cc');
            $table->string('owner_mobile_numbers')->nullable()->after('email_bcc');
            $table->renameColumn('user_can_answer_without_login', 'register_temp_user');
            $table->renameColumn('user_can_pay_without_registration', 'user_can_pay_without_answering_diet_required_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('owner_email');
            $table->dropColumn('email_cc');
            $table->dropColumn('email_bcc');
            $table->dropColumn('owner_mobile_numbers');
            $table->renameColumn('register_temp_user', 'user_can_answer_without_login');
            $table->renameColumn('user_can_pay_without_answering_diet_required_questions', 'user_can_pay_without_registration');
        });
    }
}
