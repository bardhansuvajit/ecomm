<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');

            $table->string('img_50')->comment('50px')->nullable();
            $table->string('img_200')->comment('200px')->nullable();
            $table->string('img_500')->comment('500px')->nullable();

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->comment('1: active, 0: inactive')->default(1);
            $table->bigInteger('listing_by')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'product_id' => 1,
                'img_50' => 'uploads/product/4e56fegde4645eynftyf_792.jpeg',
                'img_200' => 'uploads/product/4e56fegde4645eynftyf_792.jpeg',
            ],
            [
                'product_id' => 2,
                'img_50' => 'uploads/product/9fw84759447oisd8nhogld_792.jpeg',
                'img_200' => 'uploads/product/9fw84759447oisd8nhogld_792.jpeg',
            ],
            [
                'product_id' => 3,
                'img_50' => 'uploads/product/se45te65er6sdsr6e55r76br6775_1056.jpeg',
                'img_200' => 'uploads/product/se45te65er6sdsr6e55r76br6775_1056.jpeg',
            ],
            [
                'product_id' => 4,
                'img_50' => 'uploads/product/98ey5ftiehjdhkgfh (3).jpeg',
                'img_200' => 'uploads/product/98ey5ftiehjdhkgfh (3).jpeg',
            ],
        ];

        DB::table('product_images')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}
