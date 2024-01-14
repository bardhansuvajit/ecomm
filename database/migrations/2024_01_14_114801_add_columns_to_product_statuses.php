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
        });

        // $data = DB::table('product_statuses')->get();
        // foreach($data as $item) {
        //     if($item->name == 'Active') {
                DB::table('product_statuses')->where('name', 'Active')->update([
                    'purchase' => 1
                ]);
        //     }
        // }
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
        });
    }
}
