<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permission_sub_categories', function (Blueprint $table) {
            $table->id();

            $table->integer('category_id');
            $table->string('title');

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['category_id' => '1', 'title' => 'create', 'position' => 1],
            ['category_id' => '1', 'title' => 'read', 'position' => 2],
            ['category_id' => '1', 'title' => 'update', 'position' => 3],
            ['category_id' => '1', 'title' => 'delete', 'position' => 4],
            ['category_id' => '1', 'title' => 'status_change', 'position' => 5],

            ['category_id' => '2', 'title' => 'create', 'position' => 6],
            ['category_id' => '2', 'title' => 'read', 'position' => 7],
            ['category_id' => '2', 'title' => 'update', 'position' => 8],
            ['category_id' => '2', 'title' => 'delete', 'position' => 9],
            ['category_id' => '2', 'title' => 'status_change', 'position' => 10],

            ['category_id' => '3', 'title' => 'read', 'position' => 11],
            ['category_id' => '3', 'title' => 'update', 'position' => 12],
            ['category_id' => '3', 'title' => 'delete', 'position' => 13],
            ['category_id' => '3', 'title' => 'status_change', 'position' => 14],
        ];

        DB::table('admin_permission_sub_categories')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permission_sub_categories');
    }
}
