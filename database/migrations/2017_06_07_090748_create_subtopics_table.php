<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtopics', function (Blueprint $table) {
            $table->increments('subtopic_id')->index();
            $table->unsignedInteger('topic_id')->index();
            $table->string('subtopic_name', 100);
            $table->string('subtopic_description', 500);
            $table->enum('subtopic_status', [0, 1])->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('seq_id');
            $table->timestamps();

            $table->foreign('topic_id')
                ->references('topic_id')->on('topics')
                ->onDelete('cascade');
        });

        $faker = Faker\Factory::create();

        $limit = 20;
        for ($i = 0; $i < $limit; $i++) {
            $topic = \App\Topics::inRandomOrder()->first();
            DB::table('subtopics')->insert([ //,
                'topic_id' => $topic->topic_id,
                'subtopic_name' => $faker->realText(40),
                'subtopic_description' => $faker->text(90),
                'subtopic_status' => '1',
                'created_by' => $topic->created_by,
                'seq_id' => '0',
                'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
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
        Schema::dropIfExists('subtopics');
    }
}
