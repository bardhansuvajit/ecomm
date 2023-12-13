<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficePhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('purpose')->nullable();
            $table->text('purpose_description')->nullable();
            $table->string('country_code');
            $table->string('number');
            $table->integer('position')->default(1);

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
        Schema::dropIfExists('office_phone_numbers');
    }
}
