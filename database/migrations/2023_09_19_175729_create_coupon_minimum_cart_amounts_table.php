<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponMinimumCartAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_minimum_cart_amounts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('coupon_id');
            $table->bigInteger('currency_id');
            $table->double('minimum_cart_amount', 10,2)->default(0);

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'coupon_id' => 1,
            'currency_id' => 1,
            'minimum_cart_amount' => 999,
        ];

        DB::table('coupon_minimum_cart_amounts')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_minimum_cart_amounts');
    }
}
