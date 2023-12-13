<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->text('name');
            $table->string('code');
            $table->integer('max_no_of_usage')->default(100);
            $table->integer('user_max_no_of_usage')->default(1)->comment('max no a user can use');
            $table->tinyInteger('type')->default(1)->comment('1: public | 2: private');

            $table->date('start_date');
            $table->date('expiry_date');

            $table->text('details');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'name' => '10% off on every order',
            'code' => 'cart10',
            'max_no_of_usage' => 100,
            'user_max_no_of_usage' => 1,
            'type' => 1,
            'start_date' => date('Y-m-d'),
            'expiry_date' => date('Y-m-d', strtotime('+90 days'))
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
