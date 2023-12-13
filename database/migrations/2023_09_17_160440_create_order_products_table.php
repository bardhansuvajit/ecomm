<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            // storing product info if they are updated in future
            $table->string('product_title');
            $table->string('product_image');
            $table->string('product_slug');

            $table->tinyInteger('currency_id');
            $table->string('currency_entity', 50);
            $table->string('currency_short_name', 100);
            $table->double('mrp', 10, 2);
            $table->double('selling_price', 10, 2)->nullable();

            $table->bigInteger('variation_id')->default(0);
            $table->longText('variation_payload');
            $table->integer('qty')->default(1);

            $table->string('status', 100)->default('new');
            $table->string('cancel_reason')->nullable();
            $table->string('return_reason')->nullable();
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
        Schema::dropIfExists('order_products');
    }
}
