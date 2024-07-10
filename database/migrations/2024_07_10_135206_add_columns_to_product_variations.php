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
            $table->tinyInteger('image_status')->after('variation_option_id')->default(0)->comment('Keep image & disable it');
            $table->string('image_path')->nullable()->after('image_status');
            $table->tinyInteger('pricing_same_as_initial_product')->default(1)->comment('1: active | 0: inactive')->after('image_path');
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
            $table->dropColumn('image_status');
            $table->dropColumn('image_path');
            $table->dropColumn('pricing_same_as_initial_product');
        });
    }
}
