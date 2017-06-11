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
            $table->integer('topic_id')->index();
            $table->string('subtopic_name',100);
            $table->string('subtopic_description',500);
            $table->enum('subtopic_status',[0,1]);
            $table->integer('created_by');
            $table->integer('seq_id');
            $table->timestamps();
        });
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
