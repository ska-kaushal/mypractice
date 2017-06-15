<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examples', function (Blueprint $table) {
            $table->increments('example_id')->index();
            $table->unsignedInteger('article_id')->index();
            $table->unsignedInteger('topic_id')->index();
            $table->unsignedInteger('subtopic_id')->index();
            $table->string('example',500);
            $table->enum('example_status',[0,1])->default(0);
            $table->enum('example_type',[0,1])->default(0);
            $table->enum('is_answer',[0,1])->default(0);
            $table->enum('is_approved',[0,1,2])->default(0);
            $table->integer('created_by');
            $table->integer('approved_by');
            $table->integer('seq_id');
            $table->timestamps();
            $table->foreign('topic_id')
                ->references('topic_id')->on('topics')
                ->onDelete('cascade');
            $table->foreign('subtopic_id')
                ->references('subtopic_id')->on('subtopics')
                ->onDelete('cascade');
            $table->foreign('article_id')
                ->references('article_id')->on('articles')
                ->onDelete('cascade');

        });

        $faker = Faker\Factory::create();

        $limit = 500;

        for ($i = 0; $i < $limit; $i++) {

            $article = \App\Article::inRandomOrder()->first();
            $exType = rand(0,1);
            if($exType==1){
                $isAnswer = rand(0,1);
            }else{
                $isAnswer = 0;
            }

            DB::table('examples')->insert([ //,
                'article_id'=> $article->article_id,
                'subtopic_id'=> $article->subtopic_id,
                'topic_id'=> $article->topic_id,
                'example' => $faker->text(20),
                'approved_by'=> $article->created_by,
                'created_at'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'is_answer'=>(string) $isAnswer,
                'example_status' => (string) $faker->randomElement(['1']),
                'example_type' => (string) $exType,
                'is_approved'=> (string) $faker->randomElement(['1']),
                'created_by' => $article->created_by,
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
        Schema::dropIfExists('examples');
    }
}
