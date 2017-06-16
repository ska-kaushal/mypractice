<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userexamples', function (Blueprint $table) {
            $table->increments('user_example_id')->index();
            $table->integer('article_id')->index();
            $table->integer('topic_id')->index();
            $table->integer('subtopic_id')->index();
            $table->integer('example_id')->nullable()->index();
            $table->enum('example_type',[0,1])->default(0);
            $table->string('example',500)->nullable();
            $table->enum('example_status',[0,1])->default(0);
            $table->enum('is_approved',[0,1,2])->default(0);
            $table->integer('created_by');
            $table->integer('approved_by');
            $table->integer('seq_id');
            $table->timestamps();
        });

        $faker = Faker\Factory::create();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {

            $example = \App\Example::inRandomOrder()->where(['example_type'=>'1'])->first();
            $created_by =array_diff([1,2,3],[$example->created_by]);

            DB::table('userexamples')->insert([ //,
                'article_id'=> $example->article_id,
                'subtopic_id'=> $example->subtopic_id,
                'topic_id'=> $example->topic_id,
                'example_id' => $example->example_id,
                'approved_by'=> $example->created_by,
                'created_at'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'example_status' => (string) $faker->randomElement(['1']),
                'example_type' => (string) '1',
                'is_approved'=> (string) $faker->randomElement(['1']),
                'created_by' => array_rand($created_by,1),
                'seq_id'=>'0',
                'updated_at'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
            ]);
        }

        for ($i = 0; $i < $limit; $i++) {

            $example = \App\Example::inRandomOrder()->where(['example_type'=>'0'])->first();

            DB::table('userexamples')->insert([ //,
                'article_id'=> $example->article_id,
                'subtopic_id'=> $example->subtopic_id,
                'topic_id'=> $example->topic_id,
                'example_id' => $example->example_id,
                'example' => $faker->text(100),
                'approved_by'=> $example->created_by,
                'created_at'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'example_status' => (string) $faker->randomElement(['1']),
                'example_type' => (string) '0',
                'is_approved'=> (string) $faker->randomElement(['1','0','2']),
                'created_by' => array_rand(array_diff([1,2,3],[$example->created_by]),1),
                'seq_id'=>'0',
                'updated_at'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userexamples');
    }
}
