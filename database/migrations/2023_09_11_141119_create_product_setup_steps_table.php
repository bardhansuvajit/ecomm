<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductSetupStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_setup_steps', function (Blueprint $table) {
            $table->id();

            $table->integer('step')->default(1);
            $table->string('setup_name');
            $table->enum('required', ['y', 'n']);

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['step' => 1, 'setup_name' => 'category 1', 'required' => 'y'],
            ['step' => 2, 'setup_name' => 'category 2', 'required' => 'n'],
            ['step' => 3, 'setup_name' => 'category 3', 'required' => 'n'],
            ['step' => 4, 'setup_name' => 'title', 'required' => 'y'],
            ['step' => 5, 'setup_name' => 'cost', 'required' => 'y'],
            ['step' => 6, 'setup_name' => 'mrp', 'required' => 'n'],
            ['step' => 7, 'setup_name' => 'selling price', 'required' => 'y'],

            ['step' => 8, 'setup_name' => 'image 1', 'required' => 'y'],
            ['step' => 9, 'setup_name' => 'image 2', 'required' => 'y'],
            ['step' => 10, 'setup_name' => 'image 3', 'required' => 'y'],
            ['step' => 11, 'setup_name' => 'image others', 'required' => 'n'],

            ['step' => 12, 'setup_name' => 'highlight 1', 'required' => 'y'],
            ['step' => 13, 'setup_name' => 'highlight 2', 'required' => 'y'],
            ['step' => 14, 'setup_name' => 'highlight 3', 'required' => 'y'],
            ['step' => 15, 'setup_name' => 'highlight others', 'required' => 'n'],
            ['step' => 16, 'setup_name' => 'short description', 'required' => 'n'],
            ['step' => 17, 'setup_name' => 'long description', 'required' => 'n'],

            ['step' => 18, 'setup_name' => 'seo details', 'required' => 'n'],
        ];

        DB::table('product_setup_steps')->insert($data);

        Schema::dropIfExists('product_setup_steps');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_setup_steps');
    }
}
