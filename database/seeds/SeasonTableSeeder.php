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
        for ($i = 0; $i < 3; $i++)
        {
            Season::create([
                'name'   => '2015-2016-' . $i,
                'active' => $i === 0 ? true : false,
            ]);
        }

        for ($i = 1; $i <= 10; $i++)
        {
            DB::table('player_season')->insert([
                'player_id' => $i,
                'season_id' => 1,
            ]);
        }

    }
}
