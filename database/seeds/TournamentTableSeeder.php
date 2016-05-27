<?php

use App\Match;
use App\Season;
use App\Series;
use App\Tournament;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TournamentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $season = Season::active()->first();

        if ($season !== null) {
            $tournament = Tournament::create([
                'start'         => Carbon::today()->format("d/m/Y"),
                'end'           => Carbon::tomorrow()->format("d/m/Y"),
                'name'          => 'Tournoi',
                'series_number' => 1,
                'season_id'     => 2,
            ]);

            $serie = Series::create([
                'category'              => 'S',
                'display_order'         => 1,
                'name'                  => 'S1',
                'number_matches_rank_1' => 8,
                'number_rank'           => 4,
                'tournament_id'         => $tournament->id,
            ]);

            for ($i = 1; $i <= 15; $i++) {
                Match::create([
                    'matches_number_in_table' => $i,
                    'first_team_id'           => null,
                    'second_team_id'          => null,
                    'series_rank'             => $serie->number_rank,
                    'series_id'               => $serie->id,
                    'next_match_winner_id'    => null,
                    'next_match_looser_id'    => null,
                    'team_number_winner'      => null,
                    'team_number_looser'      => null,
                    'score_id'                => null
                ]);
            }
        }
    }
}
