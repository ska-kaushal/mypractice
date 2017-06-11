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
            $table->integer('topic_id')->index();
            $table->integer('subtopic_id')->index();
            $table->string('article_name',100);
            $table->string('article_description',500);
            $table->enum('article_status',[0,1]);
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
        Schema::dropIfExists('articles');
    }
}
