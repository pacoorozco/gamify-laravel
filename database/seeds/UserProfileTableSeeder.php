<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 * @link               https://github.com/pacoorozco/gamify-l5
 *
 */

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_profiles')->delete();

        $profile = [
            [
                'email'         => 'admin@example.com',
                'bio'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero.',
                'url'           => 'http://www.example.org/admin',
                'phone'         => '+34935555555',
                'date_of_birth' => \Carbon\Carbon::createFromDate(1977, 1, 28)->toDateTimeString(),
                'gender'        => 'male',
                'twitter'       => 'https://twitter.com/pakusland',
                'facebook'      => 'https://www.facebook.com/paco.orozco',
                'linkedin'      => 'https://www.linkedin.com/in/pacoorozco',
                'github'        => 'https://github.com/pacoorozco',
            ],
            [
                'email'         => 'user@example.com',
                'bio'           => 'Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit.',
                'url'           => 'http://www.example.org/user',
                'phone'         => '+34935555551',
                'date_of_birth' => \Carbon\Carbon::createFromDate(2008, 8, 7)->toDateTimeString(),
                'gender'        => 'male',
                'twitter'       => 'https://twitter.com/emilisho',
                'facebook'      => 'https://www.facebook.com/eampudia',
                'linkedin'      => 'https://www.linkedin.com/in/emilioa',
                'github'        => '',
            ],
        ];

        foreach ($profile as $data) {
            $user = \Gamify\User::where('email', $data['email'])->firstOrFail();

            $profile = new \Gamify\UserProfile(array_except($data, ['email']));
            $user->profile()->save($profile);
        }
    }
}
