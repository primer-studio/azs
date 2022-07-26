<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_question_id')->unsigned()->nullable();
            $table->foreign('parent_question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->string("title", 500)->index();
            $table->string("short_name", 500)->unique()->index();
            $table->string('slug', 500)->nullable();
            $table->longText("description")->nullable();
            $table->string("status", 40)->default('active');
            $table->string("image", 500)->nullable();
            $table->integer("sort")->default(0)->nullable();
            $table->json('answer_properties')->nullable();
            $table->string('available_if_parent_answer_operator')->nullable();
            $table->string('available_if_parent_answer_value')->nullable();
            $table->boolean('is_required_to_receive_diet')->default(false);
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
        Schema::dropIfExists('questions');
    }
}
