<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('is_coupon')->default(1)->comment('1: coupon, 0: voucher');
            $table->string('name');
            $table->string('slug');
            $table->string('coupon_code', 50);

            $table->tinyInteger('type')->default(1)->comment('1: percentage 2: flat');
            $table->double('amount', 8, 2);
            $table->integer('max_usage')->default(1);
            $table->integer('max_usage_single_user')->default(1);
            $table->integer('no_of_usage')->default(0);

            $table->date('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('end_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('status')->default(1)->comment('1: active | 0:inactive');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'name' => '30% Coupon',
            'slug' => '30-coupon',
            'coupon_code' => 'FIRST30',
            'type' => 1,
            'amount' => '30'
        ];

        DB::table('coupons')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
