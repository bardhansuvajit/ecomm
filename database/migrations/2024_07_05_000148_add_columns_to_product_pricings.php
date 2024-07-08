<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductPricings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_pricings', function (Blueprint $table) {
            $table->enum('variation_cost_type', ['add', 'sub'])->after('variation_child_id')->default('add')->comment('add/ sub');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_pricings', function (Blueprint $table) {
            $table->dropColumn('variation_cost_type');
        });
    }
}
