<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('set null');
            $table->bigInteger('invoice_number')->nullable();
            $table->decimal('total_amount', 16)->nullable();
            $table->decimal('total_amount_without_vat', 16)->nullable();
            $table->string('status', 50)->default('started');
            $table->boolean('service_delivered')->default(false);
            $table->string('payment_way')->nullable();
            $table->bigInteger('ipg_gateway_id')->nullable()->unsigned();
            $table->string('ipg_init_refid')->nullable()->comment('the reference ID in init step');
            $table->json('ipg_init_temp_data')->nullable()->comment('keep temporary data which in init step');
            $table->string('refid')->nullable()->comment('the main reference ID');
            $table->string('payment_code')->nullable()->comment('the payment_code after successful payment');
            $table->bigInteger('offline_payment_id')->nullable()->unsigned();
            $table->decimal('vat')->nullable();
            $table->bigInteger('promo_code_id')->nullable();
            $table->decimal('promo_codes_amount')->nullable();
            $table->json('promo_code_registered_data')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
