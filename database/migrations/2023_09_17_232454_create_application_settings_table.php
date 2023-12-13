<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApplicationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();

            $table->string('application_name');
            $table->tinyInteger('min_cart_value_shipping_charge')->default(1)->comment('1: enable | 0: disable');
            $table->tinyInteger('tax_on_order')->default(1)->comment('1: enable | 0: disable');
            $table->tinyInteger('delivery_expect_in_days')->default(1);
            $table->tinyInteger('cart_max_product_qty')->default(5);

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'application_name' => 'Ecomm',
            'min_cart_value_shipping_charge' => 1,
            'tax_on_order' => 1,
            'delivery_expect_in_days' => 5,
        ];

        DB::table('application_settings')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_settings');
    }
}
