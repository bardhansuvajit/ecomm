<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('country');
            $table->string('country_full_name');
            $table->text('flag');
            $table->string('full_name');
            $table->string('short_name', 100);
            $table->string('entity');
            $table->string('image')->nullable();

            // application shipping charge
            $table->double('minimum_cart_amount', 10,2)->default(0.00)->comment('minimum cart amount to ignore shipping amount');
            $table->double('shipping_amount', 10,2)->default(0.00)->comment('shipping amount before crossing minimum cart amount');
            $table->double('order_tax_percentage', 10,2)->default(0.00)->comment('tax percentage on cart order');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['name' => 'rupee', 'country' => 'India', 'country_full_name' => 'India', 'flag' => 'uploads/static-flag/in.svg', 'full_name' => 'Indian rupee', 'short_name' => 'INR', 'entity' => '&#8377;', 'minimum_cart_amount' => 999, 'shipping_amount' => 40, 'order_tax_percentage' => 5, 'position' => 1],
            ['name' => 'dollar', 'country' => 'USA', 'country_full_name' => 'United States of America', 'flag' => 'uploads/static-flag/us.svg', 'full_name' => 'US dollar', 'short_name' => 'USD', 'entity' => '&#36;', 'minimum_cart_amount' => 12.99, 'shipping_amount' => 0.79, 'order_tax_percentage' => 0.06, 'position' => 2],
        ];

        DB::table('currencies')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
