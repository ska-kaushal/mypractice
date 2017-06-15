<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('topic_id')->index();
            $table->string('topic_name', 100);
            $table->string('topic_description', 500);
            $table->enum('topic_status', [0, 1])->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('seq_id');
            $table->timestamps();
        });

        $faker = Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('topics')->insert([ //,
                'topic_name' => $faker->realText(25),
                'topic_description' => $faker->text(50),
                'topic_status' => '1',
                'created_by' => $faker->randomElement([1, 2, 3]),
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
        Schema::dropIfExists('topics');
    }
}
