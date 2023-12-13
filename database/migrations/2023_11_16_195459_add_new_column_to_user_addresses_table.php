<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->enum('type2', ['delivery', 'billing'])->after('type')->default('delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('type2');
        });
    }
}
