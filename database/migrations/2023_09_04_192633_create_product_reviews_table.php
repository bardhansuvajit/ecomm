<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('product_id');
            $table->bigInteger('user_id')->default(0);
            $table->tinyInteger('guest_review')->default(1)->comment('1:guest | 0:logged-in');

            $table->tinyInteger('rating')->default(1)->comment('limit: 5');
            $table->text('heading')->nullable();
            $table->longText('review')->nullable();

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
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
        Schema::dropIfExists('product_reviews');
    }
}
