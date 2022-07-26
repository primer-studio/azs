<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->tinyInteger('sort')->default(0);
            $table->timestamps();
        });

        $provinces = '[{"name":"\u0622\u0630\u0631\u0628\u0627\u06cc\u062c\u0627\u0646 \u0634\u0631\u0642\u06cc","sort":1},{"name":"\u0622\u0630\u0631\u0628\u0627\u06cc\u062c\u0627\u0646 \u063a\u0631\u0628\u06cc","sort":2},{"name":"\u0627\u0631\u062f\u0628\u06cc\u0644","sort":3},{"name":"\u0627\u0635\u0641\u0647\u0627\u0646","sort":4},{"name":"\u0627\u0644\u0628\u0631\u0632","sort":5},{"name":"\u0627\u06cc\u0644\u0627\u0645","sort":6},{"name":"\u0628\u0648\u0634\u0647\u0631","sort":7},{"name":"\u062a\u0647\u0631\u0627\u0646","sort":8},{"name":"\u062e\u0631\u0627\u0633\u0627\u0646 \u062c\u0646\u0648\u0628\u06cc","sort":9},{"name":"\u062e\u0631\u0627\u0633\u0627\u0646 \u0631\u0636\u0648\u06cc","sort":10},{"name":"\u062e\u0631\u0627\u0633\u0627\u0646 \u0634\u0645\u0627\u0644\u06cc","sort":11},{"name":"\u062e\u0648\u0632\u0633\u062a\u0627\u0646","sort":12},{"name":"\u0632\u0646\u062c\u0627\u0646","sort":13},{"name":"\u0633\u0645\u0646\u0627\u0646","sort":14},{"name":"\u0633\u06cc\u0633\u062a\u0627\u0646 \u0648\u0628\u0644\u0648\u0686\u0633\u062a\u0627\u0646","sort":15},{"name":"\u0641\u0627\u0631\u0633","sort":16},{"name":"\u0642\u0632\u0648\u06cc\u0646","sort":17},{"name":"\u0642\u0645","sort":18},{"name":"\u0644\u0631\u0633\u062a\u0627\u0646","sort":19},{"name":"\u0645\u0627\u0632\u0646\u062f\u0631\u0627\u0646","sort":20},{"name":"\u0645\u0631\u06a9\u0632\u06cc","sort":21},{"name":"\u0647\u0631\u0645\u0632\u06af\u0627\u0646","sort":22},{"name":"\u0647\u0645\u062f\u0627\u0646","sort":23},{"name":"\u0686\u0647\u0627\u0631\u0645\u062d\u0627\u0644 \u0648\u0628\u062e\u062a\u06cc\u0627\u0631\u06cc","sort":24},{"name":"\u06a9\u0631\u062f\u0633\u062a\u0627\u0646","sort":25},{"name":"\u06a9\u0631\u0645\u0627\u0646","sort":26},{"name":"\u06a9\u0631\u0645\u0627\u0646\u0634\u0627\u0647","sort":27},{"name":"\u06a9\u0647\u06af\u06cc\u0644\u0648\u06cc\u0647 \u0648\u0628\u0648\u06cc\u0631\u0627\u062d\u0645\u062f","sort":28},{"name":"\u06af\u0644\u0633\u062a\u0627\u0646","sort":29},{"name":"\u06af\u06cc\u0644\u0627\u0646","sort":30},{"name":"\u06cc\u0632\u062f","sort":31}]';
        \App\Province::insert(json_decode($provinces, true));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
