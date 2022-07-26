<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDietsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title", 500);
            $table->string('slug', 500)->unique()->nullable();
            $table->longText("description")->nullable();
            $table->integer("duration_in_day")->default(21);
            $table->string("status", 40)->default('active');
            $table->json("periods")->nullable();
            $table->string("image", 500)->nullable();
            $table->integer("sort")->default(0)->nullable();
            $table->string("page_title", 500)->nullable();
            $table->string("page_description", 500)->nullable();;
            $table->longText("page_keywords")->nullable();;
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
        Schema::dropIfExists('diets');
    }
}
