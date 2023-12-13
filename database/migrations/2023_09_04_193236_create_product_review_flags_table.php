<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_review_flags', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('product_review_id');
            $table->tinyInteger('like')->default(0)->comment('1:active | 0:inactive');
            $table->tinyInteger('dislike')->default(0)->comment('1:active | 0:inactive');
            $table->tinyInteger('funny')->default(0)->comment('1:active | 0:inactive');
            $table->tinyInteger('flag_inappropriate')->default(0)->comment('1:active | 0:inactive');
            $table->longText('comment')->nullable();

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
        Schema::dropIfExists('product_review_flags');
    }
}
