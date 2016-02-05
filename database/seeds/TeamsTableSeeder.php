<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{

    private static $teams = [];

    public function __construct()
    {

        //max et chris
        self::$teams[] = [16, 48, 2, 0, 0, 1, 0, 0, 1];

        //max et coco
        self::$teams[] = [18, 48, 2, 0, 0, 0, 0, 1, 1];

        //max
        self::$teams[] = [48, null, 2, 1, 0, 0, 0, 0, 1];

        //chris et gg
        self::$teams[] = [28, 16, 2, 0, 0, 0, 0, 1, 1];

        //chris
        self::$teams[] = [16, null, 2, 1, 0, 0, 0, 0, 1];

        //antoine et agnes
        self::$teams[] = [1, 4, 2, 0, 0, 0, 0, 1, 1];

        //antoine
        self::$teams[] = [4, null, 2, 1, 0, 0, 0, 0, 1];

        //agnes et gg
        self::$teams[] = [1, 28, 2, 0, 0, 0, 1, 0, 1];

        //agnes
        self::$teams[] = [1, null, 2, 0, 1, 0, 0, 0, 1];

        //gg
        self::$teams[] = [28, null, 2, 0, 1, 0, 0, 0, 1];

        //coco
        self::$teams[] = [18, null, 2, 0, 1, 0, 0, 0, 1];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$teams as $team)
        {
            Team::create([
                'player_one'   => $team[0],
                'player_two'   => $team[1],
                'season_id'    => $team[2],
                'simple_man'   => $team[3],
                'simple_woman' => $team[4],
                'double_man'   => $team[5],
                'double_woman' => $team[6],
                'mixte'        => $team[7],
                'enable'       => $team[8],
            ]);
        }
    }
}
