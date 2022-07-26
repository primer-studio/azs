<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliationPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliation_partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile_number')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->decimal('commission_rate', 5,2)->nullable()->comment('commission rate percentage');
            $table->string('card_number')->nullable();
            $table->text('description')->nullable();
            $table->string("status", 40)->default('active');
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
        Schema::dropIfExists('affiliation_partners');
    }
}
