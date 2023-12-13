<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUsageInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_usage_instructions', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('product_id');
            $table->string('image_small')->nullable();
            $table->string('image_medium')->nullable();
            $table->string('image_large')->nullable();
            $table->string('title');
            $table->text('details')->nullable();

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
        Schema::dropIfExists('product_usage_instructions');
    }
}
