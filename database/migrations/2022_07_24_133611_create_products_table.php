<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');
            $table->double('price', 10, 2);
            $table->double('offer_price', 10, 2)->nullable();
            $table->bigInteger('cat_id')->nullable();
            $table->bigInteger('collection_id')->nullable();

            $table->text('short_desc')->nullable();
            $table->longText('desc')->nullable();

            $table->text('tags')->nullable();
            $table->string('only_for', 20)->comment('all, men, women, kids, adult')->default('all');

            $table->text('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->tinyInteger('publish_stage')->default(0);
            $table->integer('stock')->default(1);
            $table->integer('position')->default(1);

            $table->bigInteger('listing_by')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: active | 0:inactive');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'title' => 'Womens t-shirt',
                'slug' => 'womens-t-shirt',
                'price' => '999.00',
                'offer_price' => '450.00',
            ],
            [
                'title' => 'Jeans for her',
                'slug' => 'jeans-for-her',
                'price' => '299.00',
                'offer_price' => '0.00',
            ],
            [
                'title' => 'Couples T-shirt',
                'slug' => 'couples-t-shirt',
                'price' => '899.00',
                'offer_price' => '0.00',
            ],
            [
                'title' => 'Magarmukh Sakha',
                'slug' => 'magarmukh-sakha',
                'price' => '450.00',
                'offer_price' => '0.00',
            ],
        ];

        DB::table('products')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
