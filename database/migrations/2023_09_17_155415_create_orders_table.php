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
            $table->string('guest_token', 100);
            $table->string('user_full_name');
            $table->string('user_email');
            $table->string('user_phone_no', 30);
            $table->string('user_phone_no_alt', 30);
            $table->string('user_whatsapp_no', 30);

            $table->string('delivery_method', 100)->comment('free, faster');
            $table->string('payment_method', 100)->comment('online, cod');

            $table->double('total_cart_amount', 10, 2);

            $table->double('tax_in_percentage', 10, 2);
            $table->double('tax_in_amount', 10, 2);
            $table->double('shipping_charge', 10, 2);
            $table->double('payment_method_charge', 10, 2);
            $table->double('coupon_discount', 10, 2);

            $table->double('final_order_amount', 10, 2);

            $table->bigInteger('txn_id')->nullable()->comment('online payment only');
            $table->string('ip_address', 100);
            $table->string('latitude', 100)->default('');
            $table->string('longitude', 100)->default('');

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
