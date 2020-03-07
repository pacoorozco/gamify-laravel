<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_badges', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('badge_id');
            $table->integer('repetitions')->unsigned();
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_on');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users'); // assumes a users table
            $table->foreign('badge_id')
                ->references('id')->on('badges');
            $table->primary(['user_id', 'badge_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_badges');
    }
}
