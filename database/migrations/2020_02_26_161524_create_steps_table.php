<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('diet_id')->unsigned();
            $table->foreign('diet_id')->references('id')->on('diets')->onDelete('cascade');
            $table->integer('period');
            $table->string("title", 500);
            $table->string('slug', 500)->nullable();
            $table->longText("description")->nullable();
            $table->string("status", 40)->default('active');
            $table->string("image", 500)->nullable();
            $table->integer("sort")->default(0)->nullable();
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
        Schema::dropIfExists('steps');
    }
}
