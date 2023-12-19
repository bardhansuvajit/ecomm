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

            $table->string('title1')->nullable()->comment('optional');
            $table->string('title2')->nullable()->comment('optional');
            $table->string('short_description')->nullable()->comment('optional');
            $table->text('detailed_description')->nullable()->comment('optional');

            $table->string('btn_text')->nullable()->comment('optional');

            $table->text('web_link')->nullable();
            $table->text('app_link')->nullable()->comment('optional');

            $table->text('desktop_image_small');
            $table->text('desktop_image_medium');
            $table->text('desktop_image_large');
            $table->text('desktop_image_org');

            $table->text('mobile_image_small');
            $table->text('mobile_image_medium');
            $table->text('mobile_image_large');
            $table->text('mobile_image_org');

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
