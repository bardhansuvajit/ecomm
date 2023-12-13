<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategory1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category1s', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');
            $table->text('short_desc')->nullable();
            $table->longText('detailed_desc')->nullable();

            $table->text('icon_small');
            $table->text('icon_medium');
            $table->text('icon_large');
            $table->text('icon_org');
            $table->text('banner_small');
            $table->text('banner_medium');
            $table->text('banner_large');
            $table->text('banner_org');

            $table->text('page_title');
            $table->text('meta_title');
            $table->text('meta_desc');
            $table->text('meta_keyword');

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
        Schema::dropIfExists('product_category1s');
    }
}
