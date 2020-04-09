<?php

use Gamify\Level;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('required_points');
            $table->boolean('active')->default(true);
            $table->string('image_url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default Level (this level could not be deleted).
        Level::create([
            'name' => 'Level 0',
            'required_points' => 0,
            'active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
