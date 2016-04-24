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

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__constructor();
    }

    public function index()
    {

        $tournament = Tournament::lasted()->first();

        if ($tournament != null) {

            $allSimpleTeam = User::select('users.name', 'users.forname', 'teams.id', 'users.id as userId')
                ->join('players', 'players.user_id', '=', 'users.id')
                ->join('teams', 'teams.player_one', '=', 'players.id')
                ->get();

            $allDoubleOrMixteTeam = Team::select(
                'userOne.forname AS fornameOne',
                'userOne.name AS nameOne',
                'userOne.id AS userOneId',
                'userTwo.forname AS fornameTwo',
                'userTwo.name AS nameTwo',
                'userTwo.id AS userTwoId',
                'teams.id')
                ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                ->get();

            $series = [];

            foreach ($tournament->series as $index => $serie) {

                $series[$index]['info'] = $serie;
                $debute = [];
                $derniereLigneRemplie = [];
                $matches = $serie->matches()->get();
                $orderedMatches = [];
                $matchNumber = 0;
                $maxMatchesNumber = $serie->number_matches_rank_1;
                for ($rank = 1; $rank <= $serie->number_rank; $rank++) {
                    for ($m = 0; $m < $maxMatchesNumber; $m++) {
                        $orderedMatches[$rank][$m + 1] = $matches[$matchNumber];
                        $matchNumber++;
                    }
                    $maxMatchesNumber /= 2;
                }

                for ($col = 1; $col <= $serie->number_rank; $col++) {
                    $debute[$col] = false;
                    $derniereLigneRemplie[$col] = 0;
                }

                $matchLine = [];
                for ($ligne = 1; $ligne <= $serie->number_matches_rank_1 * 2 - 1; $ligne++) {
                    for ($col = 1; $col <= $serie->number_rank; $col++) {
                        if ($debute[$col] == false) {
                            if ($this->depart($col) >= $ligne) {
                                $series[$index][$col][$ligne] = "vide";
                            } else {
                                $debute[$col] = true;
                                $matchLine[$col] = 1;
                                $derniereLigneRemplie[$col] = $ligne;

                                $match = $orderedMatches[$col][$matchLine[$col]];

                                $firstTeamName = "Personne";
                                $secondTeamName = "Personne";
                                $isOwner = false;

                                if ($match->first_team_id != null) {
                                    if ($serie->category == 'S' || $serie->category == 'SH' || $serie->category == 'SD') {

                                        $firstTeam = $allSimpleTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->first_team_id;
                                        });

                                        $firstTeamName = Helpers::getInstance()->getTeamName($firstTeam->first()->forname, $firstTeam->first()->name);

                                        if($firstTeam->first()->userId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }

                                    } else {

                                        $firstTeam = $allDoubleOrMixteTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->first_team_id;
                                        });

                                        $firstTeamName = Helpers::getInstance()->getTeamName($firstTeam->first()->fornameOne, $firstTeam->first()->nameOne,
                                            $firstTeam->first()->fornameTwo, $firstTeam->first()->nameTwo);

                                        if($firstTeam->first()->userOneId == $this->user->id || $firstTeam->first()->userTwoId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }
                                    }
                                }

                                if ($match->second_team_id != null) {
                                    if ($serie->category == 'S' || $serie->category == 'SH' || $serie->category == 'SD') {

                                        $secondTeam = $allSimpleTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->second_team_id;
                                        });

                                        $secondTeamName = Helpers::getInstance()->getTeamName($secondTeam->first()->forname, $secondTeam->first()->name);

                                        if($secondTeam->first()->userId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }

                                    } else {

                                        $secondTeam = $allDoubleOrMixteTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->second_team_id;
                                        });

                                        $secondTeamName = Helpers::getInstance()->getTeamName($secondTeam->first()->fornameOne, $secondTeam->first()->nameOne,
                                            $secondTeam->first()->fornameTwo, $secondTeam->first()->nameTwo);

                                        if($secondTeam->first()->userOneId == $this->user->id || $secondTeam->first()->userTwoId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }
                                    }
                                }

                                $series[$index][$col][$ligne]['firstTeamName'] = $firstTeamName;
                                $series[$index][$col][$ligne]['secondTeamName'] = $secondTeamName;
                                $series[$index][$col][$ligne]['score'] = $match->score;
                                $series[$index][$col][$ligne]['id'] = $match->id;
                                $series[$index][$col][$ligne]['scoreId'] = $match->score_id;
                                $series[$index][$col][$ligne]['edit'] = $match->score_id != null && $firstTeamName != "Personne" && $secondTeamName != "Personne" && ($isOwner || $this->user->hasRole('admin'));

                            }
                        } else {
                            if ($ligne == $derniereLigneRemplie[$col] + 1 + $this->interligne($col)) {
                                $matchLine[$col]++;
                                $derniereLigneRemplie[$col] = $ligne;

                                $match = $orderedMatches[$col][$matchLine[$col]];

                                $firstTeamName = "Personne";
                                $secondTeamName = "Personne";
                                $isOwner = false;

                                if ($match->first_team_id != null) {
                                    if ($serie->category == 'S' || $serie->category == 'SH' || $serie->category == 'SD') {

                                        $firstTeam = $allSimpleTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->first_team_id;
                                        });

                                        $firstTeamName = Helpers::getInstance()->getTeamName($firstTeam->first()->forname, $firstTeam->first()->name);

                                        if($firstTeam->first()->userId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }

                                    } else {

                                        $firstTeam = $allDoubleOrMixteTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->first_team_id;
                                        });

                                        $firstTeamName = Helpers::getInstance()->getTeamName($firstTeam->first()->fornameOne, $firstTeam->first()->nameOne,
                                            $firstTeam->first()->fornameTwo, $firstTeam->first()->nameTwo);

                                        if($firstTeam->first()->userOneId == $this->user->id || $firstTeam->first()->userTwoId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }
                                    }
                                }

                                if ($match->second_team_id != null) {
                                    if ($serie->category == 'S' || $serie->category == 'SH' || $serie->category == 'SD') {

                                        $secondTeam = $allSimpleTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->second_team_id;
                                        });

                                        $secondTeamName = Helpers::getInstance()->getTeamName($secondTeam->first()->forname, $secondTeam->first()->name);

                                        if($secondTeam->first()->userId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }

                                    } else {

                                        $secondTeam = $allDoubleOrMixteTeam->filter(function ($item) use ($match) {
                                            return $item->id == $match->second_team_id;
                                        });

                                        $secondTeamName = Helpers::getInstance()->getTeamName($secondTeam->first()->fornameOne, $secondTeam->first()->nameOne,
                                            $secondTeam->first()->fornameTwo, $secondTeam->first()->nameTwo);

                                        if($secondTeam->first()->userOneId == $this->user->id || $secondTeam->first()->userTwoId == $this->user->id)
                                        {
                                            $isOwner = true;
                                        }

                                    }
                                }
                                
                                $series[$index][$col][$ligne]['firstTeamName'] = $firstTeamName;
                                $series[$index][$col][$ligne]['secondTeamName'] = $secondTeamName;
                                $series[$index][$col][$ligne]['score'] = $match->score;
                                $series[$index][$col][$ligne]['id'] = $match->id;
                                $series[$index][$col][$ligne]['scoreId'] = $match->score_id;
                                $series[$index][$col][$ligne]['edit'] = $match->score_id != null && $firstTeamName != "Personne" && $secondTeamName != "Personne" && ($isOwner || $this->user->hasRole('admin'));
                            } else {
                                $series[$index][$col][$ligne] = "vide";
                            }
                        }
                    }
                }
            }

            return view('tournament.index', compact('series'));
        }

        return redirect()->route('home.index')->with('error', "Il n'y a pas d'anciens tournoi");
    }

    private function depart($col)
    {
        if ($col == 1) {
            return 0;
        } else {
            return ($col - 1) * ($col - 2) + 1;
        }
    }

    private function interligne($col)
    {
        return $col * ($col - 1) + 1;
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
