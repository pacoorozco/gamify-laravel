<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('user_profiles')->delete();

        // Creates a normal user
        $user = User::create([
            'name' => 'User',
            'username' => 'username',
            'email' => 'user@example.com',
            'password' => 'user',
            'role' => User::DEFAULT_ROLE,
        ]);

        // Attach a UserProfile for user
        $user->profile()->save(
            factory(UserProfile::class)->make([
                'date_of_birth' => Carbon::createFromDate(1975, 8, 7)->toDateTimeString(),
                'url' => 'http://www.example.org/user',
                'gender' => 'male',
                'twitter' => 'https://twitter.com/emilisho',
                'facebook' => 'https://www.facebook.com/eampudia',
                'linkedin' => 'https://www.linkedin.com/in/emilioa',
                'github' => '',
            ])
        );

        // Create an administrator user
        // Creates a normal user
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'role' => User::ADMIN_ROLE,
        ]);

        // Attach a UserProfile for admin
        $admin->profile()->save(
            factory(UserProfile::class)->make([
                'date_of_birth' => Carbon::createFromDate(1977, 1, 28)->toDateTimeString(),
                'url' => 'https://pacoorozco.info',
                'gender' => 'male',
                'twitter' => 'https://twitter.com/pakusland',
                'facebook' => 'https://www.facebook.com/paco.orozco',
                'linkedin' => 'https://www.linkedin.com/in/pacoorozco',
                'github' => 'https://github.com/pacoorozco',
            ])
        );

        // And finally creates 15 normal users with his/her profile
        factory(User::class, 15)->create()->each(function ($u) {
            $u->profile()->save(factory(UserProfile::class)->make());
        });
    }
}
