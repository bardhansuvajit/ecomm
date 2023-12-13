<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSeoPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();

            $table->string('page');
            $table->text('page_title')->nullable();

            $table->text('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_keyword')->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['page' => 'home'],
            ['page' => 'about'],
            ['page' => 'contact'],
        ];

        DB::table('seo_pages')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_pages');
    }
}
