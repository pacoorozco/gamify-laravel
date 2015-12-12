<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->delete();

        $levels = array(
            array(
                'name' => 'Level 1',
                'amount_needed' => 0,
            ),
            array(
                'name' => 'Level 2',
                'amount_needed' => 10,
            )
        );

        DB::table('levels')->insert($levels);
    }
}
