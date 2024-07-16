<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductVariations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->tinyInteger('thumb_status')->after('variation_option_id')->default(0)->comment('Keep image & disable it');
            $table->string('thumb_path')->nullable()->after('thumb_status');
            $table->tinyInteger('pricing_same_as_initial_product')->default(1)->comment('1: active | 0: inactive')->after('thumb_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn('thumb_status');
            $table->dropColumn('thumb_path');
            $table->dropColumn('pricing_same_as_initial_product');
        });
    }
}
