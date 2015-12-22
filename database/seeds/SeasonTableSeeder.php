<?php

use App\Season;
use Illuminate\Database\Seeder;

class SeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Season::create([
            'name'   => '2014-2015',
            'active' => false,
        ]);

        Season::create([
            'name'   => '2015-2016',
            'active' => true,
        ]);
    }
}
