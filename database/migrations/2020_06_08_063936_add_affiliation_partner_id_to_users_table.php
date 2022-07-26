<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffiliationPartnerIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('affiliation_partner_id')->unsigned()->nullable()->after('verification_code_set_at');
            $table->foreign('affiliation_partner_id')->references('id')->on('affiliation_partners')->onDelete('set null');
            $table->bigInteger('affiliation_partner_set_at')->nullable()->after('affiliation_partner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_affiliation_partner_id_foreign');
            $table->dropColumn('affiliation_partner_id');
            $table->dropColumn('affiliation_partner_set_at');
        });
    }
}
