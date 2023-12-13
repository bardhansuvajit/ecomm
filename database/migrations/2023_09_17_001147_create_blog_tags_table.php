<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');
            $table->text('short_desc')->nullable();
            $table->longText('detailed_desc')->nullable();

            $table->string('icon_small');
            $table->string('icon_medium');
            $table->string('icon_large');
            $table->string('icon_org');
            $table->string('banner_small');
            $table->string('banner_medium');
            $table->string('banner_large');
            $table->string('banner_org');

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
        Schema::dropIfExists('blog_tags');
    }
}
