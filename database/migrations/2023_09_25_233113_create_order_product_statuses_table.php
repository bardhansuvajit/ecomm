<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderProductStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('value');
            $table->text('details');
            $table->text('customer_message_title');
            $table->text('customer_message_details');
            $table->string('image');
            $table->string('icon');
            $table->string('color_code');
            $table->string('color_class_bootstrap');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['position' => 1, 'name' => 'New', 'value' => 'new'],
            ['position' => 2, 'name' => 'Processing', 'value' => 'processing'],
            ['position' => 3, 'name' => 'Shipped', 'value' => 'shipped'],
            ['position' => 4, 'name' => 'Delivered', 'value' => 'delivered'],
            ['position' => 5, 'name' => 'Cancelled', 'value' => 'cancelled'],
            ['position' => 6, 'name' => 'Return request raised', 'value' => 'return_request'],
            ['position' => 7, 'name' => 'Return approve', 'value' => 'return_approve'],
            ['position' => 8, 'name' => 'Return cancel', 'value' => 'return_decline'],
            ['position' => 9, 'name' => 'Return delivered', 'value' => 'return_delivered'],
            ['position' => 10, 'name' => 'Review pending', 'value' => 'review_pending'],
            ['position' => 11, 'name' => 'Review complete', 'value' => 'review_complete'],
            ['position' => 12, 'name' => 'COMPLETE', 'value' => 'complete'],
        ];

        DB::table('order_product_statuses')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_statuses');
    }
}
