<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('short_description')->nullable();
            $table->text('detailed_description')->nullable();

            $table->string('btn_text')->nullable();
            $table->text('btn_link')->nullable();

            $table->text('web_link')->nullable();
            $table->text('app_link')->nullable();

            $table->text('image_small');
            $table->text('image_medium');
            $table->text('image_large');
            $table->text('image_org');

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
        Schema::dropIfExists('banners');
    }
}
