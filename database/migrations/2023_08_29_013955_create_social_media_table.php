<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();

            $table->string('type')->comment('facebook, instagram...');
            $table->text('svg_image')->nullable();
            $table->text('link');
            $table->string('color')->nullable();
            $table->integer('position')->default(1);

            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['type' => 'facebook', 'position' => 1],
            ['type' => 'twitter', 'position' => 2],
            ['type' => 'instagram', 'position' => 3],
            ['type' => 'linkedin', 'position' => 4],
            ['type' => 'youtube', 'position' => 5]
        ];

        DB::table('social_media')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media');
    }
}
