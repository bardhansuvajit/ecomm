<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRolePermissionMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role_permission_mappings', function (Blueprint $table) {
            $table->id();

            $table->integer('role_id');
            $table->integer('permission_sub_cat_id');
            $table->integer('access')->default(1)->comment('1: active | 0: inactive');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [];
        for($i = 1; $i < 15; $i++) {
            array_push($data, ['role_id' => 1, 'permission_sub_cat_id' => $i]);
        }

        // $data = [
        //     ['role_id' => 1, 'permission_sub_cat_id' => 1],
        // ];

        DB::table('admin_role_permission_mappings')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_role_permission_mappings');
    }
}
