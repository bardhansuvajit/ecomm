<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('designation');
            $table->text('comment');
            $table->string('image_small')->nullable();
            $table->string('image_medium')->nullable();
            $table->string('image_large')->nullable();
            
            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'name' => 'Sarah Conor',
                'designation' => 'customer',
                'comment' => 'Love the convenience of Mixy and the uber-friendly service. The produce is always fresh and the meat department is first-class',
            ], [
                'name' => 'John Conor',
                'designation' => 'customer',
                'comment' => 'Love the convenience of Mixy and the uber-friendly service. The produce is always fresh and the meat department is first-class',
            ]
        ];

        DB::table('testimonials')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}
