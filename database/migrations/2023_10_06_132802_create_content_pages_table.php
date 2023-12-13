<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateContentPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_pages', function (Blueprint $table) {
            $table->id();

            $table->string('page');
            $table->string('title');
            $table->longText('content');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['page' => 'cancellation', 'title' => 'Cancellation & Return', 'content' => 'cancellation content'],
            ['page' => 'usage', 'title' => 'Terms of usage', 'content' => 'usage content'],
            ['page' => 'privacy', 'title' => 'Privacy policy', 'content' => 'privacy content'],
            ['page' => 'security', 'title' => 'Security', 'content' => 'security content'],
        ];

        DB::table('content_pages')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_pages');
    }
}
