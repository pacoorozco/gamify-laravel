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
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creates a normal user
        $user = new \Gamify\User();
        $user->name = 'User';
        $user->username = 'user';
        $user->email = 'user@example.com';
        $user->password = 'user';
        $user->role = 'user';
        $user->save();

        // Attach a UserProfile for user
        $profile = factory(\Gamify\UserProfile::class)->make();
        $profile->date_of_birth = \Carbon\Carbon::createFromDate(1975, 8, 7)->toDateTimeString();
        $profile->url = 'http://www.example.org/user';
        $profile->gender = 'male';
        $profile->twitter = 'https://twitter.com/emilisho';
        $profile->facebook = 'https://www.facebook.com/eampudia';
        $profile->linkedin = 'https://www.linkedin.com/in/emilioa';
        $profile->github = '';
        $user->profile()->save($profile);

        // Create an administrator user
        $user = new \Gamify\User();
        $user->name = 'Administrator';
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->password = 'admin';
        $user->role = 'administrator';
        $user->save();

        // Attach a UserProfile for admin
        $profile = factory(\Gamify\UserProfile::class)->make();
        $profile->date_of_birth = \Carbon\Carbon::createFromDate(1977, 1, 28)->toDateTimeString();
        $profile->url = 'https://pacoorozco.info';
        $profile->gender = 'male';
        $profile->twitter = 'https://twitter.com/pakusland';
        $profile->facebook = 'https://www.facebook.com/paco.orozco';
        $profile->linkedin = 'https://www.linkedin.com/in/pacoorozco';
        $profile->github = 'https://github.com/pacoorozco';
        $user->profile()->save($profile);

        // And finally creates 15 normal users with his/her profile
        factory(\Gamify\User::class, 15)->create()->each(function ($u) {
            $u->profile()->save(factory(\Gamify\UserProfile::class)->make());
        });
    }
}
