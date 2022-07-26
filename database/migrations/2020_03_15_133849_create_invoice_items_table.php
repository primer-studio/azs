<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_id')->unsigned();
            $table->foreign("invoice_id")->references('id')->on('invoices')->onDelete('cascade');
            $table->decimal('price', 16);
            $table->bigInteger('diet_id')->unsigned()->nullable();
            $table->foreign('diet_id')->references('id')->on('diets')->onDelete('set null');
            $table->integer('diet_period');
            $table->integer('quantity');
            $table->json('pending_questions')->nullable()->comment('the diet will not be delivered til there is any pending question');
            $table->json('diet_registered_data')->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
}
