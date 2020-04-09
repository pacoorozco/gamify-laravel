<?php

use Gamify\User;
use Illuminate\Database\Migrations\Migration;

class AddDefaultAdminUserInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
