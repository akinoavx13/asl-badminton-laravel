<?php

use App\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{

    private static $teams = [];

    public function __construct()
    {
        self::$teams[] = [4, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [6, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [7, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [8, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [9, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [1, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [3, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [6, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [7, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [2, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [5, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [6, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [8, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [2, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [4, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [1, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [2, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [3, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [4, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [5, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [7, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [2, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [3, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [6, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [7, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [8, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [9, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [1, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [2, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [3, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [4, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [5, null, 0, 0, 0, 1, 0, 1];
        self::$teams[] = [6, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [8, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [9, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [1, 22, 0, 1, 0, 1, 0, 0];
        self::$teams[] = [3, 18, 0, 1, 0, 1, 0, 0];
        self::$teams[] = [6, 69, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [7, 26, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [8, 11, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [9, 61, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [13, 45, 0, 1, 0, 1, 0, 0];
        self::$teams[] = [14, 47, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [15, 42, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [16, 30, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [20, 32, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [23, 54, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [28, 40, 0, 1, 0, 1, 0, 0];
        self::$teams[] = [34, 4, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [35, 65, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [43, 59, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [44, 62, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [49, 52, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [53, 70, 1, 0, 0, 1, 0, 0];
        self::$teams[] = [1, 4, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [3, 35, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [13, 69, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [18, 16, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [21, 23, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [22, 56, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [27, 33, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [28, 6, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [29, 53, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [37, 52, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [39, 70, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [40, 20, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [41, 25, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [45, 9, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [63, 55, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [67, 32, 0, 0, 1, 1, 0, 0];
        self::$teams[] = [48, null, 0, 0, 0, 1, 1, 0];
        self::$teams[] = [18, null, 0, 0, 0, 1, 0, 1];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$teams as $team)
        {
            Team::create([
                'player_one' => $team[0],
                'player_two' => $team[1],
                'season_id' => 2,
                'simple_man' => $team[6],
                'simple_woman' => $team[7],
                'double_man' => $team[2],
                'double_woman' => $team[3],
                'mixte' => $team[4],
                'enable' => $team[5],
            ]);
        }
    }
}
