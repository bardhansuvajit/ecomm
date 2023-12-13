<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOfficeInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_information', function (Blueprint $table) {
            $table->id();

            $table->text('full_name');
            $table->text('pretty_name');
            $table->text('short_desc')->nullable();
            $table->longText('detailed_desc')->nullable();
            $table->string('primary_logo');
            $table->string('hq_logo')->nullable()->comment('high quality');
            $table->string('watermark_logo')->nullable()->comment('optional');
            $table->string('rectangle_logo')->nullable()->comment('optional');
            $table->string('square_logo')->nullable()->comment('optional');
            $table->string('favicon')->nullable()->comment('optional');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'full_name' => 'Full company name',
            'pretty_name' => 'Pretty name',
            'primary_logo' => 'frontend-assets/img/logo.png',
        ];

        DB::table('office_information')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_information');
    }
}
