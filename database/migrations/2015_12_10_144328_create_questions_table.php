<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('short_name')->unique();
            $table->string('name');
            $table->text('question');
            $table->text('solution')->nullable();
            $table->enum('type', ['single', 'multi']);
            $table->boolean('hidden')->default(false);
            $table->enum('status', ['draft', 'publish', 'pending', 'private', 'future'])->default('draft');

            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')
                ->references('id')->on('users');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')
                ->references('id')->on('users');
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->foreign('deleted_by')
                ->references('id')->on('users');

            $table->timestamp('publication_date')->nullable();
            $table->timestamp('expiration_date')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
