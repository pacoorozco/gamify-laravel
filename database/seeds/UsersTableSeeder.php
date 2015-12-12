<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = array(
            array(
                'username' => 'admin',
                'name' => 'Administrator',
                'email' => 'admin@example.org',
                'password' => 'admin',
                'role' => 'administrator',
            ),
            array(
                'username' => 'user',
                'name' => 'User',
                'email' => 'user@example.org',
                'password' => 'user',
                'role' => 'default',
            )
        );

        foreach ($users as $data) {
            $user = \Gamify\User::create([
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => $data['role']
            ]);

            $profile = new \Gamify\UserProfile(['gender' => 'female']);
            $user->profile()->save($profile);

            Log::info('Created user ' . $data['username']);
        }
    }
}
