<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shortname')->unique();
            $table->string('name');
            $table->text('question');
            $table->text('solution')->nullable();
            $table->enum('type', array('single', 'multi'));
            $table->boolean('hidden')->default(false);
            $table->enum('status', array('draft', 'publish', 'pending', 'private'))->default('draft');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')
                ->references('id')->on('users');
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')
                ->references('id')->on('users'); // assumes a users table

            $table->timestamp('publish_on');
            $table->timestamp('unpublish_on');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
