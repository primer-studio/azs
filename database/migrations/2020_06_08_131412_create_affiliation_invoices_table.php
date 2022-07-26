<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliationInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliation_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('affiliation_partner_id')->unsigned();
            $table->foreign("affiliation_partner_id")->references('id')->on('affiliation_partners')->onDelete('cascade');
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->foreign("invoice_id")->references('id')->on('invoices')->onDelete('set null');
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->foreign("profile_id")->references('id')->on('profiles')->onDelete('set null');
            $table->decimal('total_amount', 16)->nullable();
            $table->decimal('total_amount_without_vat', 16)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable()->comment('commission rate percentage');
            $table->decimal('commission_amount', 16, 2)->nullable()->comment('commission rate amount');
            $table->string('status', 100)->default(\App\Constants\GeneralConstants::AFFILIATION_INVOICE_STATUS_CREATED);
            $table->bigInteger('checkout_date')->nullable();
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
        Schema::dropIfExists('affiliation_invoices');
    }
}
