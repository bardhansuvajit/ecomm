<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->comment('maintain sequence');
            $table->bigInteger('user_id')->comment('0: Guest user');
            $table->bigInteger('order_address_id');

            $table->string('delivery_method', 100)->comment('free, faster');
            $table->string('payment_method', 100)->comment('online, cod');

            $table->double('cart_total_order_amount', 10, 2);
            $table->double('cart_product_discount', 10, 2)->default(0)->nullable();

            $table->bigInteger('coupon_id')->default(0)->nullable();
            $table->double('coupon_discount', 10, 2)->default(0)->nullable();
            $table->tinyInteger('coupon_type')->default(0)->comment('1: percentage 2: flat');

            $table->double('delivery_charges', 10, 2);
            $table->double('payment_method_charge', 10, 2)->default(0)->nullable();

            $table->double('final_order_amount', 10, 2);
            $table->integer('total_order_product')->default(1);
            $table->integer('total_order_qty')->default(1);

            $table->bigInteger('txn_id')->default(0)->comment('online payment only');

            $table->tinyInteger('cancellation')->default(0)->comment('1: cancel via admin only');
            $table->string('cancellation_reason')->default('');

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
        Schema::dropIfExists('orders');
    }
}
