<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->string('image_small')->nullable();

            $table->text('bio')->nullable();
            $table->text('company')->nullable();
            $table->text('designation')->nullable();
            $table->text('location_info')->nullable();
            $table->text('skills')->nullable();
            $table->text('experience')->nullable();

            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'name' => env('APP_NAME').' Admin',
            'email' => 'admin@admin.com',
            'mobile_no' => '9876543210',
            'username' => 'admin@admin.com',
            'password' => Hash::make('secret'),
            'image_small' => 'backend-assets/images/user2-160x160.jpg',
        ];

        DB::table('admins')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
