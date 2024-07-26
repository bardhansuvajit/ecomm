<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('category')->after('product_id');
            $table->string('trigger_type')->after('category')->default('low')->comment('high, medium, low');

            $table->text('user_agent')->after('ip_address');
            $table->string('device_type')->nullable()->after('user_agent');
            $table->string('browser')->nullable()->after('device_type');
            $table->string('browser_version')->nullable()->after('browser')->comment('beta');
            $table->string('platform')->nullable()->after('browser_version');
            $table->string('platform_version')->nullable()->after('platform')->comment('beta');
            $table->string('languages')->nullable()->after('platform_version');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('trigger_type');
            $table->dropColumn('user_agent');
            $table->dropColumn('device_type');
            $table->dropColumn('browser');
            $table->dropColumn('browser_version');
            $table->dropColumn('platform');
            $table->dropColumn('platform_version');
            $table->dropColumn('languages');
        });
    }
}
