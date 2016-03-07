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

        foreach (range(0, 5) as $index) {
            \Gamify\Level::create([
                'name' => 'Level ' . $index,
                'amount_needed' => ($index * 10),
            ]);
        }
    }
}
