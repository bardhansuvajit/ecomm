<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('coupon_id');
            $table->bigInteger('order_id');

            // coupon
            $table->string('coupon_name');
            $table->string('coupon_code');
            $table->tinyInteger('discount_type')->default(1)->comment('1: flat | 2: percentage');
            $table->double('discount_amount', 8, 2);

            $table->softDeletes();
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
        Schema::dropIfExists('coupon_usages');
    }
}
