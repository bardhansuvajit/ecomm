<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->comment('0: guest user');
            $table->bigInteger('product_id');
            $table->tinyInteger('save_for_later')->default(0)->comment('0: cart | 1: saved');
            $table->integer('qty')->default(1);
            $table->string('ip', 100);
            $table->string('guest_token', 100)->nullable();
            $table->bigInteger('coupon_code')->default(0);

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
        Schema::dropIfExists('carts');
    }
}
