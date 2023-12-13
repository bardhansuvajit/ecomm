<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');
            $table->string('full_name');
            $table->string('contact_no1');
            $table->string('contact_no2')->comment('alternate number');

            $table->string('zipcode', 10);
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->text('street_address');
            $table->text('locality');
            $table->text('landmark');

            $table->string('type')->default('not specified')->comment('home, work, not specified');
            $table->string('ip_address', 150);

            $table->tinyInteger('default')->default(0)->comment('1: active | 0: inactive');
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
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
        Schema::dropIfExists('user_addresses');
    }
}
