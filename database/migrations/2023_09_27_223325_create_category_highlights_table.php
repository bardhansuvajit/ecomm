<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryHighlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_highlights', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('category_id');
            $table->enum('level', [1,2,3,4])->default(1)->comment('1: category 1 | 2: category 2 | 3: category 3 | 4: category 4');
            $table->text('title');
            $table->text('short_details');
            $table->text('link')->nullable();
            $table->string('image_small');
            $table->string('image_medium');
            $table->string('image_large');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_highlights');
    }
}
