<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_countries', function (Blueprint $table) {
            $table->id();

            $table->string('ip_address');
            $table->string('country');
            $table->tinyInteger('currency_id');
            $table->text('json_payload');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'ip_address' => '127.0.0.1',
            'country' => 'India',
            'currency_id' => 1,
        ];

        DB::table('ip_countries')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_countries');
    }
}
