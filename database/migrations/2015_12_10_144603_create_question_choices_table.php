<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
            $table->string('text', 512);
            $table->boolean('correct')->default(false);
            $table->integer('score');
            $table->index('question_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_choices');
    }
}
