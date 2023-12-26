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

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['page' => 'cancellation', 'title' => 'Cancellation & Return', 'content' => '<p>cancellation content</p>'],
            ['page' => 'terms', 'title' => 'Terms & Conditions', 'content' => '<p>terms content</p>'],
            ['page' => 'privacy', 'title' => 'Privacy policy', 'content' => '<p>privacy content</p>'],
            ['page' => 'security', 'title' => 'Security', 'content' => '<p>security content</p>'],
            ['page' => 'support', 'title' => 'Customer Support', 'content' => '<p>Customer Support</p>'],
            ['page' => 'service', 'title' => 'Terms of service', 'content' => '<p>Terms of service</p>']
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
