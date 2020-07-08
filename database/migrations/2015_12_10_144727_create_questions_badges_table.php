<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateQuestionsBadgesTable
 *
 * This table 'questions_badges' has never been used, so it's removed since v2.5.0.
 *
 * @deprecated since v2.5.0
 */
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
            $table->unsignedInteger('question_id');
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
            $table->unsignedInteger('badge_id');
            $table->foreign('badge_id')
                ->references('id')->on('badges')
                ->onDelete('cascade');
            $table->enum('when', ['success', 'fail', 'always']);
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
