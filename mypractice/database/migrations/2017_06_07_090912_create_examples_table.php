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
            $table->integer('article_id')->index();
            $table->integer('topic_id')->index();
            $table->integer('subtopic_id')->index();
            $table->string('example',500);
            $table->enum('example_status',[0,1]);
            $table->enum('is_approved',[0,1]);
            $table->integer('created_by');
            $table->integer('approved_by');
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
        Schema::dropIfExists('examples');
    }
}
