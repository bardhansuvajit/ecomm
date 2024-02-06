<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMailFileSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_file_setups', function (Blueprint $table) {
            $table->id();

            $table->string('type', 100);
            $table->string('subject');
            $table->string('mail_from');
            $table->string('blade_file');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'type' => 'forgot-password',
            'subject' => 'Forgot password',
            'mail_from' => 'no-reply',
            'blade_file' => 'forgot-password',
        ];

        DB::table('mail_file_setups')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_file_setups');
    }
}
