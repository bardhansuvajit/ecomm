<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateImageSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_sizes', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('width');
            $table->string('height');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['type' => 'banner', 'width' => 1015, 'height' => 250],
            ['type' => 'notice', 'width' => 500, 'height' => 500],
            ['type' => 'category-icon', 'width' => 500, 'height' => 500],
            ['type' => 'category-banner', 'width' => 1400, 'height' => 300],
            ['type' => 'category-highlight', 'width' => 1000, 'height' => 1000],
            ['type' => 'company-primary-logo', 'width' => 500, 'height' => 200],
            ['type' => 'company-hd-logo', 'width' => 1500, 'height' => 600],
            ['type' => 'company-watermark-logo', 'width' => 500, 'height' => 200],
            ['type' => 'company-rectangle-logo', 'width' => 500, 'height' => 200],
            ['type' => 'company-square-logo', 'width' => 500, 'height' => 500],
            ['type' => 'company-fav-icon', 'width' => 150, 'height' => 150],
            ['type' => 'partner', 'width' => 1000, 'height' => 1000],
            ['type' => 'product', 'width' => 1000, 'height' => 1500],
            ['type' => 'profile-image', 'width' => 500, 'height' => 500],
            ['type' => 'testimonial', 'width' => 1000, 'height' => 1000],
            ['type' => 'blog-banner', 'width' => 1400, 'height' => 300],
            ['type' => 'blog-category-icon', 'width' => 500, 'height' => 500],
            ['type' => 'blog-category-banner', 'width' => 1400, 'height' => 300],
            ['type' => 'blog-tag-icon', 'width' => 500, 'height' => 500],
            ['type' => 'blog-tag-banner', 'width' => 1400, 'height' => 300],
            ['type' => 'service', 'width' => 1000, 'height' => 800],
            ['type' => 'collection-icon', 'width' => 500, 'height' => 500],
            ['type' => 'collection-banner', 'width' => 1400, 'height' => 300],
            ['type' => 'variation', 'width' => 1000, 'height' => 1000],
            ['type' => 'product-highlight', 'width' => 50, 'height' => 50],
        ];

        DB::table('image_sizes')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_sizes');
    }
}
