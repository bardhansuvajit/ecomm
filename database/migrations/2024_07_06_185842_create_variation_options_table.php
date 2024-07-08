<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('variation_id')->constrained('variations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('value', 100);

            $table->string('category')->default('all');
            // $table->foreignId('category_id')->constrained('product_category1s')->comment('not using for now')->nullable();

            $table->json('equivalent')->nullable();
            $table->json('information')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();

            $table->integer('position')->default(1);
            $table->tinyInteger('status')->default(1)->comment('1: active | 0: inactive');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['variation_id' => '1',     'value' => 'Red', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '1',     'value' => 'Black', 'category' => 'all', 'equivalent' => null, 'information' => null],

            ['variation_id' => '2',     'value' => 'XXS',   'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'Double Extra small']), 
            'information' => null],
            ['variation_id' => '2',     'value' => 'XS',    'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'Extra small']), 
            'information' => null],
            ['variation_id' => '2',     'value' => 'S',     'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'Small']), 
            'information' => null],
            ['variation_id' => '2',     'value' => 'M',     'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'Medium']), 
            'information' => null],
            ['variation_id' => '2',     'value' => 'L',     'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'Large']), 
            'information' => null],
            ['variation_id' => '2',     'value' => 'XL',    'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'Extra Large']), 
            'information' => null],
            ['variation_id' => '2',     'value' => '2XL',   'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'XXL, Double Extra Large']), 
            'information' => null],
            ['variation_id' => '2',     'value' => '3XL',   'category' => 'clothes,men,women',    'equivalent' => json_encode(['name' => 'XXXL, Triple Extra Large']), 
            'information' => null],

            ['variation_id' => '2',     'value' => '6',     'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 40']),
            'information' => json_encode(['lenth' => '25cm'])],
            ['variation_id' => '2',     'value' => '7',     'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 41']),
            'information' => json_encode(['lenth' => '26cm'])],
            ['variation_id' => '2',     'value' => '8',     'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 42']),
            'information' => json_encode(['lenth' => '27cm'])],
            ['variation_id' => '2',     'value' => '9',     'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 43']),
            'information' => json_encode(['lenth' => '28cm'])],
            ['variation_id' => '2',     'value' => '10',    'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 44']),
            'information' => json_encode(['lenth' => '29cm'])],
            ['variation_id' => '2',     'value' => '11',    'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 45']),
            'information' => json_encode(['lenth' => '30cm'])],
            ['variation_id' => '2',     'value' => '12',    'category' => 'shoes,men,women',      'equivalent' => json_encode(['name' => 'EURO 46']),
            'information' => json_encode(['lenth' => '31cm'])],

            ['variation_id' => '3',     'value' => '1 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '2 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '3 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '4 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '5 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '6 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '7 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '8 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '9 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '10 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '12 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '15 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '20 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '30 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '50 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
            ['variation_id' => '3',     'value' => '100 Pack', 'category' => 'all', 'equivalent' => null, 'information' => null],
        ];

        DB::table('variation_options')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variation_options');
    }
}
