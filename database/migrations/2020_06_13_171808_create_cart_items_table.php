<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->foreign("profile_id")->references('id')->on('profiles')->onDelete('cascade');
            $table->bigInteger('diet_id')->unsigned()->nullable();
            $table->foreign("diet_id")->references('id')->on('diets')->onDelete('cascade');
            $table->integer('period')->nullable();
            $table->integer('step_number')->nullable();
            $table->boolean('is_proforma_invoice')->default(false);
            $table->string('last_activity_url')->nullable();
            $table->bigInteger('reminder_sms_sent_at')->nullable();
            $table->unique(['profile_id', 'diet_id', 'period']);
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
