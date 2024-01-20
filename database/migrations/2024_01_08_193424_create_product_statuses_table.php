<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->tinyInteger('show_in_frontend')->default(0)->comment('1: active | 0: inactive');
            $table->tinyInteger('show_email_alert')->default(1)->comment('1: active | 0: inactive');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['name' => 'Draft', 'show_in_frontend' => 0, 'show_email_alert' => 0],
            ['name' => 'Active', 'show_in_frontend' => 1, 'show_email_alert' => 0],
            ['name' => 'Hide', 'show_in_frontend' => 0, 'show_email_alert' => 0],
            ['name' => 'Out of Stock', 'show_in_frontend' => 1, 'show_email_alert' => 1],
            ['name' => 'Coming Soon', 'show_in_frontend' => 1, 'show_email_alert' => 1],
            ['name' => 'Unavailable', 'show_in_frontend' => 1, 'show_email_alert' => 1],
            ['name' => 'Sold Out', 'show_in_frontend' => 1, 'show_email_alert' => 1]
        ];

        DB::table('product_statuses')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_statuses');
    }
}
