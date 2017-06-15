<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('article_id')->index();
            $table->unsignedInteger('topic_id')->index();
            $table->unsignedInteger('subtopic_id')->index();
            $table->string('article_name',100);
            $table->string('article_description',500);
            $table->enum('article_status',[0,1])->default(0);
            $table->enum('is_approved',[0,1])->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('approved_by')->default(0);
            $table->integer('seq_id');
            $table->timestamps();
            $table->foreign('topic_id')
                ->references('topic_id')->on('topics')
                ->onDelete('cascade');
            $table->foreign('subtopic_id')
                ->references('subtopic_id')->on('subtopics')
                ->onDelete('cascade');

        });

        $faker = Faker\Factory::create();

        $limit = 30;
        for ($i = 0; $i < $limit; $i++) {
            $subtopic = \App\Subtopic::inRandomOrder()->first();
            DB::table('articles')->insert([ //,
                'subtopic_id'=> $subtopic->subtopic_id,
                'topic_id'=> $subtopic->topic_id,
                'article_name' => $faker->realText(15),
                'article_description' => $faker->text(100),
                'article_status' => '1',
                'is_approved'=> $faker->randomElement([1]),
                'approved_by'=> $subtopic->created_by,
                'created_by' => $subtopic->created_by,
                'seq_id'=>'0',
                'created_at'=>$faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
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
        Schema::dropIfExists('articles');
    }
}
