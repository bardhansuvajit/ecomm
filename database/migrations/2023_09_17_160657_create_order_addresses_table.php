<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');

            // shipping address
            $table->string('shipping_address_user_full_name');
            $table->string('shipping_address_user_phone_no1', 30);
            $table->string('shipping_address_user_phone_no2', 30);

            $table->string('shipping_address_postcode', 30);
            $table->string('shipping_address_country', 100);
            $table->string('shipping_address_state', 100);
            $table->string('shipping_address_city', 200);
            $table->text('shipping_address_locality');
            $table->text('shipping_address_street_address');
            $table->string('shipping_address_landmark');
            $table->enum('shipping_address_type', ['home', 'work', 'not specified'])->default('not specified');
            $table->string('shipping_address_latitude')->default('');
            $table->string('shipping_address_longitude')->default('');

            // billing address
            $table->string('billing_address_user_full_name');
            $table->string('billing_address_user_phone_no1', 30);
            $table->string('billing_address_user_phone_no2', 30);

            $table->string('billing_address_postcode', 30);
            $table->string('billing_address_country', 100);
            $table->string('billing_address_state', 100);
            $table->string('billing_address_city', 200);
            $table->text('billing_address_locality');
            $table->text('billing_address_street_address');
            $table->string('billing_address_landmark');
            $table->enum('billing_address_type', ['home', 'work', 'not specified'])->default('not specified');
            $table->string('billing_address_latitude')->default('');
            $table->string('billing_address_longitude')->default('');

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
        Schema::dropIfExists('order_addresses');
    }
}
