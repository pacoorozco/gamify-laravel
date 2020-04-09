<?php

use Gamify\User;
use Illuminate\Database\Migrations\Migration;

class AddDefaultUsersInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = User::create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => 'user',
            'role' => User::USER_ROLE,
        ]);
        $user->profile()->create();

        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'role' => User::ADMIN_ROLE,
        ]);
        $admin->profile()->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
