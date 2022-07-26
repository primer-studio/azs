<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflinePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->nullable()->unsigned();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('set null');
            $table->decimal('amount', 16);
            $table->bigInteger('payment_date')->nullable();
            $table->string('payment_type',50);
            $table->string('tracking_number', 50)->nullable();
            $table->string('card_number', 50)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->bigInteger('verified_at')->default(false);
            $table->boolean('seen')->default(false);
            $table->bigInteger('admin_id')->nullable()->unsigned()->comment('the admin ID which verified this payment');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
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
        Schema::dropIfExists('offline_payments');
    }
}
