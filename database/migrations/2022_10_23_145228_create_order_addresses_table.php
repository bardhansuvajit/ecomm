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
            $table->bigInteger('user_id');
            // $table->bigInteger('order_id');

            $table->string('full_name', 255);
            $table->string('mobile_no', 20);
            $table->string('whatsapp_no', 20)->nullable();
            $table->string('alt_no', 20)->nullable();
            $table->string('email', 255);

            $table->string('pincode', 30);
            $table->string('locality', 200);
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100)->default('India');

            $table->text('street_address');
            $table->text('landmark')->nullable();
            $table->enum('type', ['home', 'work', 'not specified'])->default('not specified');

            $table->string('ip_address', 255);
            $table->string('latitude', 255)->default('');
            $table->string('longitude', 255)->default('');

            $table->tinyInteger('status')->default(1)->comment('1:active | 0:inactive');
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
