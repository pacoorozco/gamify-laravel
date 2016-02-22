<?php

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

        $profile = array(
            array(
                'username' => 'admin',
                'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero.',
                'url' => 'http://www.example.org/admin',
                'phone' => '+34935555555',
                'mobile' => '+34934444444',
                'date_of_birth' => \Carbon\Carbon::createFromDate(1977,1,28)->toDateTimeString(),
                'gender' => 'male',
                'twitter' => 'https://twitter.com/pakusland',
                'facebook' => 'https://www.facebook.com/paco.orozco',
                'linkedin' => 'https://www.linkedin.com/in/pacoorozco',
                'github' => 'https://github.com/pacoorozco',
            ),
            array(
                'username' => 'user',
                'bio' => 'Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit.',
                'url' => 'http://www.example.org/user',
                'phone' => '+34935555551',
                'mobile' => '+34934444441',
                'date_of_birth' => \Carbon\Carbon::createFromDate(2008,8,7)->toDateTimeString(),
                'gender' => 'male',
                'twitter' => 'https://twitter.com/emilisho',
                'facebook' => 'https://www.facebook.com/eampudia',
                'linkedin' => 'https://www.linkedin.com/in/emilioa',
                'github' => '',
            )
        );

        foreach ($profile as $data) {
            $user = \Gamify\User::where('username', $data['username'])->firstOrFail();

            $profile = new \Gamify\UserProfile(array_except($data, ['username']));
            $user->profile()->save($profile);
        }
    }
}
