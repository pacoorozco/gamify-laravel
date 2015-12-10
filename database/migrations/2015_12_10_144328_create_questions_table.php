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
            $table->enum('status', array('draft', 'publish', 'unpublish'))->default('draft');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')
                ->references('id')->on('users');
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')
                ->references('id')->on('users'); // assumes a users table

            $table->string('image_file_name')->nullable();
            $table->integer('image_file_size')->nullable();
            $table->string('image_content_type')->nullable();
            $table->timestamp('image_updated_at')->nullable();

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
