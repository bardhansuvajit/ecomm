<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_statuses', function (Blueprint $table) {
            $table->tinyInteger('purchase')->after('show_in_frontend')->default('0')->comment('1: active | 0: inactive');
            $table->tinyInteger('show_price_in_detail_page')->after('purchase')->default('0')->comment('1: active | 0: inactive');
            $table->tinyInteger('show_price_in_out_page')->after('show_price_in_detail_page')->default('0')->comment('1: active | 0: inactive');
        });

        DB::table('product_statuses')->where('name', 'Active')->update([
            'purchase' => 1,
            'show_price_in_detail_page' => 1,
            'show_price_in_out_page' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_statuses', function (Blueprint $table) {
            $table->dropColumn('purchase');
            $table->dropColumn('show_price_in_detail_page');
            $table->dropColumn('show_price_in_out_page');
        });
    }
}
