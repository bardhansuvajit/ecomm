<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('value');
            $table->tinyInteger('stage')->default(0)->comment('1: live | 0: test');
            $table->string('image');
            $table->text('details');

            $table->string('test_key1', 200);
            $table->string('live_key1', 200);
            $table->string('test_key2', 200);
            $table->string('live_key2', 200);

            $table->string('company_name_display', 100);
            $table->text('description');
            $table->string('image_rectangle', 200);
            $table->string('image_square', 200);
            $table->string('theme_color', 30);
            $table->tinyInteger('checked')->default(0)->comment('1: active | 0: inactive');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['name' => 'Razorpay', 'value' => 'razorpay', 'position' => 1, 'checked' => 0],
            ['name' => 'Stripe', 'value' => 'stripe', 'position' => 2, 'checked' => 0],
            ['name' => 'Cash on delivery', 'value' => 'cash-on-delivery', 'position' => 3, 'checked' => 1]
        ];

        DB::table('payment_methods')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
