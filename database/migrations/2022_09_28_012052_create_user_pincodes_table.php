<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserPincodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pincodes', function (Blueprint $table) {
            $table->id();

            $table->string('ip_address');
            $table->string('pincode', 20);
            $table->string('locality');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->tinyInteger('selected')->default(0)->comment('1:default | 0:inactive');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

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
        Schema::dropIfExists('user_pincodes');
    }
}
