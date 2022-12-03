<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combos', function (Blueprint $table) {
            $table->id();

            $table->text('title');
            $table->double('offer_price', 10, 2);

            $table->string('img_50')->comment('50px')->nullable();
            $table->string('img_200')->comment('200px')->nullable();
            $table->string('img_500')->comment('500px')->nullable();

            $table->tinyInteger('status')->comment('1: active, 0: inactive')->default(1);
            $table->bigInteger('listing_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('combos');
    }
}
