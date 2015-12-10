<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_badges', function (Blueprint $table) {
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
            $table->integer('badge_id')->unsigned();
            $table->foreign('badge_id')
                ->references('id')->on('badges')
                ->onDelete('cascade');
            $table->enum('when', array('success', 'fail', 'always'));
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
        Schema::drop('questions_badges');
    }
}
