<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserSocialLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_logins', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('client_id')->comment('app_id')->nullable();
            $table->text('client_secret')->comment('app_secret')->nullable();
            $table->text('redirect_url')->nullable();

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            'name' => 'google',
            'client_id' => '65139693010-fg1u8233h518asgsi08noqcefskld8bi.apps.googleusercontent.com',
            'position' => 1,
            'status' => 1,
        ];

        DB::table('user_social_logins')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_social_logins');
    }
}
