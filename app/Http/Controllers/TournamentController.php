<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests;
use App\Http\Requests\TournamentStoreRequest;
use App\Season;
use App\Series;
use App\Team;
use App\Tournament;
use App\User;

class TournamentController extends Controller
{
    public static function routes($router)
    {

        $router->get('index', [
            'uses' => 'TournamentController@index',
            'as'   => 'tournament.index',
        ]);

        $router->get('create', [
            'middleware' => 'admin',
            'uses'       => 'TournamentController@create',
            'as'         => 'tournament.create',
        ]);

        $router->post('create', [
            'middleware' => 'admin',
            'uses'       => 'TournamentController@store',
            'as'         => 'tournament.store',
        ]);

    }

    public function index()
    {

        $tournament = Tournament::lasted()->first();

        if ($tournament != null) {

            $allSimpleTeam = User::select('users.name', 'users.forname', 'teams.id')
                ->join('players', 'players.user_id', '=', 'users.id')
                ->join('teams', 'teams.player_one', '=', 'players.id')
                ->get();

            $allDoubleOrMixteTeam = Team::select('userOne.forname AS fornameOne',
                'userOne.name AS nameOne',
                'userTwo.forname AS fornameTwo',
                'userTwo.name AS nameTwo',
                'teams.id')
                ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                ->get();

            $series = [];

            foreach ($tournament->series as $index => $serie) {
                $series[$index]['info'] = $serie;
                $maxMatchesNumber = $serie->number_matches_rank_1;
                $lastedMatchNumber = 0;

                for ($rank = 1; $rank <= $serie->number_rank; $rank++) {
                    for ($m = 0; $m < $maxMatchesNumber; $m++) {
                        $match = $serie->matches[$lastedMatchNumber];

                        $firstTeamName = "Personne";
                        $secondTeamName = "Personne";

                        if($match->first_team_id != null){
                            if ($serie->category == 'S' || $serie->category == 'SH' || $serie->category == 'SD') {

                                $user = $allSimpleTeam->filter(function($item) use($match){
                                    return $item->id == $match->first_team_id;
                                });

                                $firstTeamName = Helpers::getInstance()->getTeamName($user->first()->forname, $user->first()->name);

                            } else {

                                $user = $allDoubleOrMixteTeam->filter(function($item) use($match){
                                    return $item->id == $match->first_team_id;
                                });

                                $firstTeamName = Helpers::getInstance()->getTeamName($user->first()->fornameOne, $user->first()->nameOne,
                                    $user->first()->fornameTwo, $user->first()->nameTwo);
                            }
                        }

                        if($match->second_team_id != null){
                            if ($serie->category == 'S' || $serie->category == 'SH' || $serie->category == 'SD') {

                                $user = $allSimpleTeam->filter(function($item) use($match){
                                    return $item->id == $match->second_team_id;
                                });

                                $secondTeamName = Helpers::getInstance()->getTeamName($user->first()->forname, $user->first()->name);

                            } else {

                                $user = $allDoubleOrMixteTeam->filter(function($item) use($match){
                                    return $item->id == $match->second_team_id;
                                });

                                $secondTeamName = Helpers::getInstance()->getTeamName($user->first()->fornameOne, $user->first()->nameOne,
                                    $user->first()->fornameTwo, $user->first()->nameTwo);
                            }
                        }

                        $series[$index][$rank][$m]['id'] = $match->id;
                        $series[$index][$rank][$m]['scoreId'] = $match->score_id;
                        $series[$index][$rank][$m]['edit'] = $match->score_id != null && $firstTeamName != "Personne" && $secondTeamName != "Personne";
                        $series[$index][$rank][$m]['firstTeam'] = $firstTeamName;
                        $series[$index][$rank][$m]['secondTeam'] = $secondTeamName;

                        $lastedMatchNumber++;
                    }
                    $maxMatchesNumber /= 2;
                }
            }

            return view('tournament.index', compact('series'));
        }

        return redirect()->route('home.index')->with('error', "Il n'y a pas d'anciens tournoi");
    }

    public function create()
    {

        $tournament = new Tournament();

        return view('tournament.create', compact('tournament'));
    }

    public function store(TournamentStoreRequest $request)
    {

        $season = Season::active()->first();

        if ($season !== null) {
            $tournament = Tournament::create([
                'start'         => $request->start,
                'end'           => $request->end,
                'name'          => $request->name,
                'series_number' => $request->series_number,
                'season_id'     => $season->id,
            ]);

            for ($i = 1; $i <= $tournament->series_number; $i++) {

                Series::create([
                    'category'              => 'S',
                    'display_order'         => $i,
                    'name'                  => '',
                    'number_matches_rank_1' => 8,
                    'number_rank'           => 4,
                    'tournament_id'         => $tournament->id,
                ]);
            }

            return redirect()->route('series.create')->with('succes', "Le tournoi vient d'être créé !");

        }

        return redirect()->route('home.index')->with('error', "Pour créer un tournoi il faut d'abord une saison !");
    }

}
