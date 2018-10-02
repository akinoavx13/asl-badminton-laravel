<?php

namespace App\Http\Controllers;

use App\ChampionshipPool;
use App\Period;
use App\Tournament;
use App\PlayersReservation;
use App\Score;
use App\Series;
use App\Match;
use App\Season;
use App\Team;
use App\Player;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {

        $router->get('/index', [
            'uses' => 'DashboardController@index',
            'as'   => 'dashboard.index',
        ]);

    }

    public function index()
    {

        $activeSeason = Season::active()->first();
        $userID = $this->user->id;

        if ($activeSeason !== null)
        {

            $currentChampionship = Period::getCurrentPeriod();
            $currentTournament = Tournament::getCurrentTournament();

            if ($currentTournament !== null)
            {
                $tableTournament['simple'] = [];
                $tableTournament['double'] = [];
                $tableTournament['mixte'] = [];
                $serie = [];

                $serie['simple'] = Series::select('series.id', 'series.category', 'series.name')
                    ->leftjoin('matches', 'matches.series_id', '=', 'series.id')
                    ->leftjoin('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
                    ->leftjoin('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
                    ->leftjoin('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
                    ->leftjoin('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
                    ->leftjoin('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
                    ->leftjoin('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
                    ->where('series.tournament_id', '=', $currentTournament->id)
                    ->where('series.category', 'like', 'S%')
                    ->where('userOneT1.id', '=', $userID)
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'S%')
                        ->where('userOneT2.id', '=', $userID);
                    })
                    ->distinct()
                    ->get();

                $serie['double'] = Series::select('series.id', 'series.category', 'series.name')
                    ->leftjoin('matches', 'matches.series_id', '=', 'series.id')
                    ->leftjoin('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
                    ->leftjoin('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
                    ->leftjoin('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
                    ->leftjoin('players as playerTwoT1', 'playerTwoT1.id', '=', 'teamOne.player_two')
                    ->leftjoin('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
                    ->leftjoin('players as playerTwoT2', 'playerTwoT2.id', '=', 'teamTwo.player_two')
                    ->leftjoin('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
                    ->leftjoin('users as userTwoT1', 'userTwoT1.id', '=', 'playerTwoT1.user_id')
                    ->leftjoin('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
                    ->leftjoin('users as userTwoT2', 'userTwoT2.id', '=', 'playerTwoT2.user_id')
                    ->where('series.tournament_id', '=', $currentTournament->id)
                    ->where('series.category', 'like', 'D%')
                    ->where('userOneT1.id', '=', $userID)
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'D%')
                        ->where('userOneT2.id', '=', $userID);
                    })
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'D%')
                        ->where('userTwoT1.id', '=', $userID);
                    })
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'D%')
                        ->where('userTwoT2.id', '=', $userID);
                    })
                    ->distinct()
                    ->get();

                $serie['mixte'] = Series::select('series.id', 'series.category', 'series.name')
                    ->leftjoin('matches', 'matches.series_id', '=', 'series.id')
                    ->leftjoin('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
                    ->leftjoin('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
                    ->leftjoin('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
                    ->leftjoin('players as playerTwoT1', 'playerTwoT1.id', '=', 'teamOne.player_two')
                    ->leftjoin('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
                    ->leftjoin('players as playerTwoT2', 'playerTwoT2.id', '=', 'teamTwo.player_two')
                    ->leftjoin('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
                    ->leftjoin('users as userTwoT1', 'userTwoT1.id', '=', 'playerTwoT1.user_id')
                    ->leftjoin('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
                    ->leftjoin('users as userTwoT2', 'userTwoT2.id', '=', 'playerTwoT2.user_id')
                    ->where('series.tournament_id', '=', $currentTournament->id)
                    ->where('series.category', 'like', 'M%')
                    ->where('userOneT1.id', '=', $userID)
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'M%')
                        ->where('userOneT2.id', '=', $userID);
                    })
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'M%')
                        ->where('userTwoT1.id', '=', $userID);
                    })
                    ->orWhere(function ($query) use ($currentTournament, $userID)
                    {
                        $query->where('series.tournament_id', '=', $currentTournament->id)
                        ->where('series.category', 'like', 'M%')
                        ->where('userTwoT2.id', '=', $userID);
                    })
                    ->distinct()
                    ->get();
                    
                foreach ($serie['simple'] as $index => $oneSerie) {
                    $tableTournament['simple'][$oneSerie['name']] = $this->createTableTournament('simple', $oneSerie, $currentTournament, $userID);
                }
                foreach ($serie['double'] as $index => $oneSerie) {
                    $tableTournament['double'][$oneSerie['name']] = $this->createTableTournament('double', $oneSerie, $currentTournament, $userID);
                }
                foreach ($serie['mixte'] as $index => $oneSerie) {
                    $tableTournament['mixte'][$oneSerie['name']] = $this->createTableTournament('mixte', $oneSerie, $currentTournament, $userID);
                }
              
                //dd($tableTournament);  

                return view('dashboard.indexT', compact('tableTournament', 'pools', 'anchor', 'userID'));
            }

            if ($currentChampionship !== null)
            {

                $mySimplePool = ChampionshipPool::select('championship_pools.number', 'championship_pools.id')
                    ->join('championship_rankings', 'championship_rankings.championship_pool_id', '=',
                        'championship_pools.id')
                    ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
                    ->join('players', 'players.id', '=', 'teams.player_one')
                    ->join('users', 'users.id', '=', 'players.user_id')
                    ->where('teams.simple_' . $this->user->gender, true)
                    ->where('teams.enable', true)
                    ->where('users.id', $this->user->id)
                    ->where('championship_pools.period_id', $currentChampionship->id)
                    ->first();

                $myDoublePool = ChampionshipPool::select('championship_pools.number', 'championship_pools.id')
                    ->join('championship_rankings', 'championship_rankings.championship_pool_id', '=',
                        'championship_pools.id')
                    ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
                    ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                    ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                    ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                    ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                    ->where('teams.double_' . $this->user->gender, true)
                    ->where('userOne.id', $this->user->id)
                    ->where('championship_pools.period_id', $currentChampionship->id)
                    ->where('teams.enable', true)
                    ->orWhere(function ($query) use ($currentChampionship)
                    {
                        $query->where('teams.double_' . $this->user->gender, true)
                            ->where('userTwo.id', $this->user->id)
                            ->where('championship_pools.period_id', $currentChampionship->id)
                            ->where('teams.enable', true);
                    })
                    ->first();

                $myMixtePool = ChampionshipPool::select('championship_pools.number', 'championship_pools.id')
                    ->join('championship_rankings', 'championship_rankings.championship_pool_id', '=',
                        'championship_pools.id')
                    ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
                    ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                    ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                    ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                    ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                    ->where('teams.mixte', true)
                    ->where('userOne.id', $this->user->id)
                    ->where('championship_pools.period_id', $currentChampionship->id)
                    ->where('teams.enable', true)
                    ->orWhere(function ($query) use ($currentChampionship)
                    {
                        $query->where('teams.mixte', true)
                            ->where('userTwo.id', $this->user->id)
                            ->where('championship_pools.period_id', $currentChampionship->id)
                            ->where('teams.enable', true);
                    })
                    ->first();

                $anchor['simple'] = 'null';
                $anchor['double'] = 'null';
                $anchor['mixte'] = 'null';

                if ($currentChampionship->hasChampionshipSimpleWoman(true))
                {
                    $anchor['simple'] = $mySimplePool != null ? 'simple_' . $this->user->gender . '_' . $mySimplePool->number : 'null';
                }
                else
                {
                    $anchor['simple'] = $mySimplePool != null ? 'simple_' . $mySimplePool->number : 'null';
                }

                if ($currentChampionship->hasChampionshipDoubleWoman(true))
                {
                    $anchor['double'] = $myDoublePool != null ? 'double_' . $this->user->gender . '_' . $myDoublePool->number : 'null';
                }
                else
                {
                    $anchor['double'] = $myDoublePool != null ? 'double_' . $myDoublePool->number : 'null';
                }

                $anchor['mixte'] = $myMixtePool != null ? 'mixte_' . $myMixtePool->number : 'null';

                $tableReservation['simple'] = $this->createTableReservation($mySimplePool, 'simple', $activeSeason,
                    $currentChampionship);
                $tableReservation['double'] = $this->createTableReservation($myDoublePool, 'double', $activeSeason,
                    $currentChampionship);
                $tableReservation['mixte'] = $this->createTableReservation($myMixtePool, 'mixte', $activeSeason,
                    $currentChampionship);

                $pools = [];

                if ($mySimplePool != null)
                {
                    $pools['simple']['pool_number'] = $mySimplePool->number;
                    $pools['simple']['pool_id'] = $mySimplePool->id;
                }

                if ($myDoublePool != null)
                {
                    $pools['double']['pool_number'] = $myDoublePool->number;
                    $pools['double']['pool_id'] = $myDoublePool->id;
                }

                if ($myMixtePool != null)
                {
                    $pools['mixte']['pool_number'] = $myMixtePool->number;
                    $pools['mixte']['pool_id'] = $myMixtePool->id;
                }

                if (count($tableReservation) > 0)
                {
                    return view('dashboard.index', compact('tableReservation', 'pools', 'anchor', 'userID'));
                }
            }
        }

        return redirect()->back()->with('error', "Tableau de bord indisponible, il n'y a pas de championnat ni de tournoi en cours pour le moment !");
    }


private function createTableTournament($type, $serie, $currentTournament, $userID)
{
    $result = [];

    if ($type == 'simple') {
        $allMatches = Match::select(
                    'userOneT1.name as userOneT1Name',                      'userOneT1.forname as userOneT1Forname',
                    'userOneT1.id as userOneT1ID',                          'userOneT1.avatar as userOneT1Avatar',
                    'userOneT1.email as userOneT1Email',                    'userOneT1.state as userOneT1State', 
                    'userOneT1.ending_holiday as userOneT1EndingHoliday',   'userOneT1.ending_injury as userOneT1EndingInjury',

                    'userOneT2.name as userOneT2Name',                      'userOneT2.forname as userOneT2Forname',
                    'userOneT2.id as userOneT2ID',                          'userOneT2.avatar as userOneT2Avatar',
                    'userOneT2.email as userOneT2Email',                    'userOneT2.state as userOneT2State', 
                    'userOneT2.ending_holiday as userOneT2EndingHoliday',   'userOneT2.ending_injury as userOneT2EndingInjury',

                    'matches.id as matchID', 'info_looser_second_team', 'info_looser_first_team', 'matches.score_id as scoreID',
                    'matches.first_team_id', 'matches.second_team_id'
                    )
                    ->leftjoin('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
                    ->leftjoin('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
                    ->leftjoin('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
                    ->leftjoin('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
                    ->leftjoin('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
                    ->leftjoin('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
                    ->where('matches.series_id', $serie['id'])
                    ->where('userOneT1.id', '=', $userID)
                    ->orWhere(function ($query) use ($serie, $userID)
                    {
                        $query->where('matches.series_id', $serie['id'])
                        ->where('userOneT2.id', '=', $userID);
                    })
                    ->distinct()
                    ->get();
    } else {
        $allMatches = Match::select(
                    'userOneT1.name as userOneT1Name',                      'userOneT1.forname as userOneT1Forname',
                    'userOneT1.id as userOneT1ID',                          'userOneT1.avatar as userOneT1Avatar',
                    'userOneT1.email as userOneT1Email',                    'userOneT1.state as userOneT1State', 
                    'userOneT1.ending_holiday as userOneT1EndingHoliday',   'userOneT1.ending_injury as userOneT1EndingInjury',

                    'userOneT2.name as userOneT2Name',                      'userOneT2.forname as userOneT2Forname',
                    'userOneT2.id as userOneT2ID',                          'userOneT2.avatar as userOneT2Avatar',
                    'userOneT2.email as userOneT2Email',                    'userOneT2.state as userOneT2State', 
                    'userOneT2.ending_holiday as userOneT2EndingHoliday',   'userOneT2.ending_injury as userOneT2EndingInjury',

                    'userTwoT1.name as userTwoT1Name',                      'userTwoT1.forname as userTwoT1Forname',
                    'userTwoT1.id as userTwoT1ID',                          'userTwoT1.avatar as userTwoT1Avatar',
                    'userTwoT1.email as userTwoT1Email',                    'userTwoT1.state as userTwoT1State', 
                    'userTwoT1.ending_holiday as userTwoT1EndingHoliday',   'userTwoT1.ending_injury as userTwoT1EndingInjury',

                    'userTwoT2.name as userTwoT2Name',                      'userTwoT2.forname as userTwoT2Forname',
                    'userTwoT2.id as userTwoT2ID',                          'userTwoT2.avatar as userTwoT2Avatar',
                    'userTwoT2.email as userTwoT2Email',                    'userTwoT2.state as userTwoT2State', 
                    'userTwoT2.ending_holiday as userTwoT2EndingHoliday',   'userTwoT2.ending_injury as userTwoT2EndingInjury',

                    'matches.id as matchID', 'info_looser_second_team', 'info_looser_first_team', 'matches.score_id as scoreID',
                    'matches.first_team_id', 'matches.second_team_id'
                    )
                    ->leftjoin('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
                    ->leftjoin('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
                    ->leftjoin('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
                    ->leftjoin('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
                    ->leftjoin('players as playerTwoT1', 'playerTwoT1.id', '=', 'teamOne.player_two')
                    ->leftjoin('players as playerTwoT2', 'playerTwoT2.id', '=', 'teamTwo.player_two')
                    ->leftjoin('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
                    ->leftjoin('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
                    ->leftjoin('users as userTwoT1', 'userTwoT1.id', '=', 'playerTwoT1.user_id')
                    ->leftjoin('users as userTwoT2', 'userTwoT2.id', '=', 'playerTwoT2.user_id')
                    ->where('matches.series_id', $serie['id'])
                    ->where('userOneT1.id', '=', $userID)
                    ->orWhere(function ($query) use ($serie, $userID)
                    {
                        $query->where('matches.series_id', $serie['id'])
                        ->where('userOneT2.id', '=', $userID);
                    })
                    ->orWhere(function ($query) use ($serie, $userID)
                    {
                        $query->where('matches.series_id', $serie['id'])
                        ->where('userTwoT1.id', '=', $userID);
                    })
                    ->orWhere(function ($query) use ($serie, $userID)
                    {
                        $query->where('matches.series_id', $serie['id'])
                        ->where('userTwoT2.id', '=', $userID);
                    })
                    ->distinct()
                    ->get();
                
    }

    if ($type == 'simple') {
        foreach ($allMatches as $index => $match) {
            $result[$index]['userFirstTeamName'] = $match->userOneT1Forname . " " . $match->userOneT1Name;
            $result[$index]['userFirstTeamId'] = $match->userOneT1ID;
            $result[$index]['userFirstTeamAvatar'] = $match->userOneT1Avatar;
            $result[$index]['userFirstTeamEmail'] = $match->userOneT1Email;
            $result[$index]['userFirstTeamState'] = $match->userOneT1State;
            if ($match->userOneT1EndingInjury != null) {
                $userFirstTeamEndingInjury = explode('-', $match->userOneT1EndingInjury);
                $result[$index]['userFirstTeamEndingInjury'] =
                    ucfirst(Date::create($userFirstTeamEndingInjury[0],
                        $userFirstTeamEndingInjury[1],
                        $userFirstTeamEndingInjury[2])->format('l j F'));
            }
            if ($match->userOneT1EndingHoliday != null) {
                $userFirstTeamEndingHoliday = explode('-', $match->userOneT1EndingHoliday);
                $result[$index]['userFirstTeamEndingHoliday'] =
                    ucfirst(Date::create($userFirstTeamEndingHoliday[0],
                        $userFirstTeamEndingHoliday[1], $userFirstTeamEndingHoliday[2])->format('l j F'));
            }
            
            $result[$index]['userSecondTeamName'] =
                $match->userSecondTeamForname . " " . $match->userOneT2Forname . " " . $match->userOneT2Name;
            $result[$index]['userSecondTeamId'] = $match->userOneT2ID;
            $result[$index]['userSecondTeamAvatar'] = $match->userOneT2Avatar;
            $result[$index]['userSecondTeamEmail'] = $match->userOneT2Email;
            $result[$index]['userSecondTeamState'] = $match->userOneT2State;
            if ($match->userOneT2EndingInjury != null) {
                $userSecondTeamEndingInjury = explode('-', $match->userOneT2EndingInjury);
                $result[$index]['userSecondTeamEndingInjury'] =
                    ucfirst(Date::create($userSecondTeamEndingInjury[0], $userSecondTeamEndingInjury[1],
                        $userSecondTeamEndingInjury[2])
                        ->format('l j F'));
            }
            if ($match->userOneT2EndingHoliday != null) {
                $userSecondTeamEndingHoliday = explode('-', $match->userOneT2EndingHoliday);
                $result[$index]['userSecondTeamEndingHoliday'] =
                    ucfirst(Date::create($userSecondTeamEndingHoliday[0],
                        $userSecondTeamEndingHoliday[1], $userSecondTeamEndingHoliday[2])
                        ->format('l j F'));
            }

            if ($this->user->id == $match->userOneT1ID || $match->userOneT2ID == null) {
            $result[$index]['imTheFirstTeam'] = true;
            }
            else {
                $result[$index]['imTheFirstTeam'] = false;    
            }
            $result[$index]['isOpponentKnown'] = true;
            if ($match->userOneT1ID == null) {
                $result[$index]['isOpponentKnown'] = false;
                $result[$index]['userFirstTeamName'] = $match->info_looser_first_team;  
                
            } 
            if ($match->userOneT2ID == null) {
                $result[$index]['isOpponentKnown'] = false;
                $result[$index]['userSecondTeamName'] = $match->info_looser_second_team;
            } 

            if ($match->scoreID != null) {
            $scoreMatch = Score::select('*')
            ->where('id', '=', $match->scoreID)
            ->first();

            
            $result[$index]['firstSetFirstTeam'] = $scoreMatch->first_set_first_team;
            $result[$index]['firstSetSecondTeam'] = $scoreMatch->first_set_second_team;
            $result[$index]['secondSetFirstTeam'] = $scoreMatch->second_set_first_team;
            $result[$index]['secondSetSecondTeam'] = $scoreMatch->second_set_second_team;
            $result[$index]['thirdSetFirstTeam'] = $scoreMatch->third_set_first_team;
            $result[$index]['thirdSetSecondTeam'] = $scoreMatch->third_set_second_team;
            $result[$index]['myWo'] = $scoreMatch->my_wo;
            $result[$index]['hisWo'] = $scoreMatch->his_wo;
            $result[$index]['unplayed'] = $scoreMatch->unplayed;
            $result[$index]['scoreId'] = $scoreMatch->id;
            $result[$index]['isFirstTeamWin'] = $scoreMatch->first_team_win;
            $result[$index]['isSecondTeamWin'] = $scoreMatch->second_team_win;

            $reservation = PlayersReservation::select('players_reservations.date',
                'time_slots.start', 'courts.number')
                ->join('time_slots', 'time_slots.id', '=', 'players_reservations.time_slot_id')
                ->join('courts', 'courts.id', '=', 'players_reservations.court_id')
                ->where('first_team', $scoreMatch->first_team_id)
                ->where('second_team', $scoreMatch->second_team_id)
                ->where('players_reservations.date', '>=', $currentTournament->start->format('Y-m-d'))
                ->where('players_reservations.date', '<=', $currentTournament->end->format('Y-m-d'))
                ->orWhere(function ($query) use ($scoreMatch, $currentTournament)
                {
                    $query->where('second_team', $scoreMatch->first_team_id)
                        ->where('first_team', $scoreMatch->second_team_id)
                        ->where('players_reservations.date', '>=', $currentTournament->start->format('Y-m-d'))
                        ->where('players_reservations.date', '<=', $currentTournament->end->format('Y-m-d'));
                })
                ->first();

            $result[$index]['reservation'] = $reservation !== null ?
                ucfirst(Date::create($reservation->date->year, $reservation->date->month,
                    $reservation->date->day)->format('l j F')) . ' sur le court n° ' .
                $reservation->number . ' à ' . $reservation->start
                : null;
        }
        // $result[$index]['reservation'] = null;

        }
    } else {
        foreach ($allMatches as $index => $match) {
            // user One Team One
            $result[$index]['userOneFirstTeamName'] = $match->userOneT1Forname . " " . $match->userOneT1Name;
            $result[$index]['userOneFirstTeamId'] = $match->userOneT1ID;
            $result[$index]['userOneFirstTeamAvatar'] = $match->userOneT1Avatar;
            $result[$index]['userOneFirstTeamEmail'] = $match->userOneT1Email;
            $result[$index]['userOneFirstTeamState'] = $match->userOneT1State;
            if ($match->userOneT1EndingInjury != null) {
                $userOneFirstTeamEndingInjury = explode('-', $match->userOneT1EndingInjury);
                $result[$index]['userOneFirstTeamEndingInjury'] =
                    ucfirst(Date::create($userOneFirstTeamEndingInjury[0],
                        $userOneFirstTeamEndingInjury[1],
                        $userOneFirstTeamEndingInjury[2])->format('l j F'));
            }
            if ($match->userOneT1EndingHoliday != null) {
                $userOneFirstTeamEndingHoliday = explode('-', $match->userOneT1EndingHoliday);
                $result[$index]['userOneFirstTeamEndingHoliday'] =
                    ucfirst(Date::create($userOneFirstTeamEndingHoliday[0],
                        $userOneFirstTeamEndingHoliday[1], $userOneFirstTeamEndingHoliday[2])->format('l j F'));
            }
            // user Two Team One
            $result[$index]['userTwoFirstTeamName'] = $match->userTwoT1Forname . " " . $match->userTwoT1Name;
            $result[$index]['userTwoFirstTeamId'] = $match->userTwoT1ID;
            $result[$index]['userTwoFirstTeamAvatar'] = $match->userTwoT1Avatar;
            $result[$index]['userTwoFirstTeamEmail'] = $match->userTwoT1Email;
            $result[$index]['userTwoFirstTeamState'] = $match->userTwoT1State;
            if ($match->userTwoT1EndingInjury != null) {
                $userTwoFirstTeamEndingInjury = explode('-', $match->userTwoT1EndingInjury);
                $result[$index]['userTwoFirstTeamEndingInjury'] =
                    ucfirst(Date::create($userTwoFirstTeamEndingInjury[0],
                        $userTwoFirstTeamEndingInjury[1],
                        $userTwoFirstTeamEndingInjury[2])->format('l j F'));
            }
            if ($match->userTwoT1EndingHoliday != null) {
                $userTwoFirstTeamEndingHoliday = explode('-', $match->userTwoT1EndingHoliday);
                $result[$index]['userTwoFirstTeamEndingHoliday'] =
                    ucfirst(Date::create($userTwoFirstTeamEndingHoliday[0],
                        $userTwoFirstTeamEndingHoliday[1], $userTwoFirstTeamEndingHoliday[2])->format('l j F'));
            }

            // User One Team Two
            $result[$index]['userOneSecondTeamName'] =
                $match->userOneSecondTeamForname . " " . $match->userOneT2Forname . " " . $match->userOneT2Name;
            $result[$index]['userOneSecondTeamId'] = $match->userOneT2ID;
            $result[$index]['userOneSecondTeamAvatar'] = $match->userOneT2Avatar;
            $result[$index]['userOneSecondTeamEmail'] = $match->userOneT2Email;
            $result[$index]['userOneSecondTeamState'] = $match->userOneT2State;
            if ($match->userOneT2EndingInjury != null) {
                $userOneSecondTeamEndingInjury = explode('-', $match->userOneT2EndingInjury);
                $result[$index]['userOneSecondTeamEndingInjury'] =
                    ucfirst(Date::create($userOneSecondTeamEndingInjury[0], $userOneSecondTeamEndingInjury[1],
                        $userOneSecondTeamEndingInjury[2])
                        ->format('l j F'));
            }
            if ($match->userOneT2EndingHoliday != null) {
                $userOneSecondTeamEndingHoliday = explode('-', $match->userOneT2EndingHoliday);
                $result[$index]['userOneSecondTeamEndingHoliday'] =
                    ucfirst(Date::create($userOneSecondTeamEndingHoliday[0],
                        $userOneSecondTeamEndingHoliday[1], $userOneSecondTeamEndingHoliday[2])
                        ->format('l j F'));
            }
            // User Two Team Two
            $result[$index]['userTwoSecondTeamName'] =
                $match->userTwoSecondTeamForname . " " . $match->userTwoT2Forname . " " . $match->userTwoT2Name;
            $result[$index]['userTwoSecondTeamId'] = $match->userTwoT2ID;
            $result[$index]['userTwoSecondTeamAvatar'] = $match->userTwoT2Avatar;
            $result[$index]['userTwoSecondTeamEmail'] = $match->userTwoT2Email;
            $result[$index]['userTwoSecondTeamState'] = $match->userTwoT2State;
            if ($match->userTwoT2EndingInjury != null) {
                $userTwoSecondTeamEndingInjury = explode('-', $match->userTwoT2EndingInjury);
                $result[$index]['userTwoSecondTeamEndingInjury'] =
                    ucfirst(Date::create($userTwoSecondTeamEndingInjury[0], $userTwoSecondTeamEndingInjury[1],
                        $userTwoSecondTeamEndingInjury[2])
                        ->format('l j F'));
            }
            if ($match->userTwoT2EndingHoliday != null) {
                $userTwoSecondTeamEndingHoliday = explode('-', $match->userTwoT2EndingHoliday);
                $result[$index]['userTwoSecondTeamEndingHoliday'] =
                    ucfirst(Date::create($userTwoSecondTeamEndingHoliday[0],
                        $userTwoSecondTeamEndingHoliday[1], $userTwoSecondTeamEndingHoliday[2])
                        ->format('l j F'));
            }

            if ($this->user->id == $match->userOneT1ID || $this->user->id == $match->userTwoT1ID || $match->userOneT2ID == null) {
            $result[$index]['imTheFirstTeam'] = true;
            }
            else {
                $result[$index]['imTheFirstTeam'] = false;    
            }
            $result[$index]['isOpponentKnown'] = true;
            if ($match->userOneT1ID == null) {
                $result[$index]['isOpponentKnown'] = false;
                $result[$index]['userOneFirstTeamName'] = $match->info_looser_first_team;
                $result[$index]['userTwoFirstTeamName'] = $match->info_looser_first_team;  
                
            } 
            if ($match->userOneT2ID == null) {
                $result[$index]['isOpponentKnown'] = false;
                $result[$index]['userOneSecondTeamName'] = $match->info_looser_second_team;
                $result[$index]['userTwoSecondTeamName'] = $match->info_looser_second_team;
            } 

            if ($match->scoreID != null) {
            $scoreMatch = Score::select('*')
            ->where('id', '=', $match->scoreID)
            ->first();

            
            $result[$index]['firstSetFirstTeam'] = $scoreMatch->first_set_first_team;
            $result[$index]['firstSetSecondTeam'] = $scoreMatch->first_set_second_team;
            $result[$index]['secondSetFirstTeam'] = $scoreMatch->second_set_first_team;
            $result[$index]['secondSetSecondTeam'] = $scoreMatch->second_set_second_team;
            $result[$index]['thirdSetFirstTeam'] = $scoreMatch->third_set_first_team;
            $result[$index]['thirdSetSecondTeam'] = $scoreMatch->third_set_second_team;
            $result[$index]['myWo'] = $scoreMatch->my_wo;
            $result[$index]['hisWo'] = $scoreMatch->his_wo;
            $result[$index]['unplayed'] = $scoreMatch->unplayed;
            $result[$index]['scoreId'] = $scoreMatch->id;
            $result[$index]['isFirstTeamWin'] = $scoreMatch->first_team_win;
            $result[$index]['isSecondTeamWin'] = $scoreMatch->second_team_win;

            $reservation = PlayersReservation::select('players_reservations.date',
                'time_slots.start', 'courts.number')
                ->join('time_slots', 'time_slots.id', '=', 'players_reservations.time_slot_id')
                ->join('courts', 'courts.id', '=', 'players_reservations.court_id')
                ->where('first_team', $scoreMatch->first_team_id)
                ->where('second_team', $scoreMatch->second_team_id)
                ->where('players_reservations.date', '>=', $currentTournament->start->format('Y-m-d'))
                ->where('players_reservations.date', '<=', $currentTournament->end->format('Y-m-d'))
                ->orWhere(function ($query) use ($scoreMatch, $currentTournament)
                {
                    $query->where('second_team', $scoreMatch->first_team_id)
                        ->where('first_team', $scoreMatch->second_team_id)
                        ->where('players_reservations.date', '>=', $currentTournament->start->format('Y-m-d'))
                        ->where('players_reservations.date', '<=', $currentTournament->end->format('Y-m-d'));
                })
                ->first();

            $result[$index]['reservation'] = $reservation !== null ?
                ucfirst(Date::create($reservation->date->year, $reservation->date->month,
                    $reservation->date->day)->format('l j F')) . ' sur le court n° ' .
                $reservation->number . ' à ' . $reservation->start
                : null;
        }
        //$result[$index]['reservation'] = null;
    }
   
    }

    return $result;
}


    private function createTableReservation($myPool, $type, $season, $currentChampionship)
    {
        $result = [];

        if ($myPool !== null)
        {
            if ($type === 'simple')
            {

                $myTeam = Team::select('teams.id')
                    ->join('players', 'players.id', '=', 'teams.player_one')
                    ->join('users', 'users.id', '=', 'players.user_id')
                    ->where('users.id', $this->user->id)
                    ->whereNull('teams.player_two')
                    ->where('players.season_id', $season->id)
                    ->where('teams.enable', true)
                    ->first();

                if ($myTeam !== null)
                {
                    $scores = Score::select(
                        'userFirstTeam.name as userFirstTeamName', 'userFirstTeam.forname as userFirstTeamForname',
                        'userFirstTeam.id as userFirstTeamId', 'userFirstTeam.avatar as userFirstTeamAvatar',
                        'userFirstTeam.email as userFirstTeamEmail', 'userFirstTeam.state as userFirstTeamState',
                        'userFirstTeam.ending_holiday as userFirstTeamEndingHoliday',
                        'userFirstTeam.ending_injury as userFirstTeamEndingInjury',
                        'rankingFirstTeam.rank as rankFirstTeam',
                        'userSecondTeam.name as userSecondTeamName', 'userSecondTeam.forname as userSecondTeamForname',
                        'userSecondTeam.id as userSecondTeamId', 'userSecondTeam.avatar as userSecondTeamAvatar',
                        'userSecondTeam.email as userSecondTeamEmail', 'userSecondTeam.state as userSecondTeamState',
                        'userSecondTeam.ending_holiday as userSecondTeamEndingHoliday',
                        'userSecondTeam.ending_injury as userSecondTeamEndingInjury',
                        'rankingSecondTeam.rank as rankSecondTeam',
                        'scores.first_team_win', 'scores.second_team_win', 'firstTeam.id as firstTeamId',
                        'secondTeam.id as secondTeamId',
                        'scores.first_set_first_team', 'scores.first_set_second_team', 'scores.second_set_first_team',
                        'scores.second_set_second_team', 'scores.third_set_first_team', 'scores.third_set_second_team',
                        'scores.my_wo', 'scores.his_wo', 'scores.unplayed',
                        'scores.id as scoreId')
                        ->allScoresSimpleInSelectedPool($myPool->id)
                        ->where('firstTeam.id', $myTeam->id)
                        ->where('scores.created_at', '>=', $currentChampionship->start->format('Y-m-d'))
                        ->where('scores.created_at', '<=', $currentChampionship->end->format('Y-m-d'))
                        ->orWhere(function ($query) use ($myTeam, $myPool, $currentChampionship)
                        {
                            $query->allScoresSimpleInSelectedPool($myPool->id)
                                ->where('secondTeam.id', $myTeam->id)
                                ->where('scores.created_at', '>=', $currentChampionship->start->format('Y-m-d'))
                                ->where('scores.created_at', '<=', $currentChampionship->end->format('Y-m-d'));
                        })
                        ->get();

                }
            }
            else
            {

                $myTeam = Team::select('teams.id')
                    ->join('seasons', 'seasons.id', '=', 'teams.season_id')
                    ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                    ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                    ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                    ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                    ->where('userOne.id', $this->user->id)
                    ->where('seasons.id', $season->id)
                    ->where('teams.enable', true)
                    ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $this->user->gender), true)
                    ->orWhere(function ($query) use ($season, $type)
                    {
                        $query->where('userTwo.id', $this->user->id)
                            ->where('seasons.id', $season->id)
                            ->where('teams.enable', true)
                            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $this->user->gender), true);
                    })
                    ->first();

                if ($myTeam !== null)
                {
                    $scores = Score::select(
                        'userOneFirstTeam.name as userOneFirstTeamName',
                        'userOneFirstTeam.forname as userOneFirstTeamForname',
                        'userOneFirstTeam.id as userOneFirstTeamId',
                        'userOneFirstTeam.avatar as userOneFirstTeamAvatar',
                        'userOneFirstTeam.email as userOneFirstTeamEmail',
                        'userOneFirstTeam.state as userOneFirstTeamState',
                        'userOneFirstTeam.ending_holiday as userOneFirstTeamEndingHoliday',
                        'userOneFirstTeam.ending_injury as userOneFirstTeamEndingInjury',

                        'userTwoFirstTeam.name as userTwoFirstTeamName',
                        'userTwoFirstTeam.forname as userTwoFirstTeamForname',
                        'userTwoFirstTeam.id as userTwoFirstTeamId',
                        'userTwoFirstTeam.avatar as userTwoFirstTeamAvatar',
                        'userTwoFirstTeam.email as userTwoFirstTeamEmail',
                        'userTwoFirstTeam.state as userTwoFirstTeamState',
                        'userTwoFirstTeam.ending_holiday as userTwoFirstTeamEndingHoliday',
                        'userTwoFirstTeam.ending_injury as userTwoFirstTeamEndingInjury',

                        'rankingFirstTeam.rank as rankFirstTeam',

                        'userOneSecondTeam.name as userOneSecondTeamName',
                        'userOneSecondTeam.forname as userOneSecondTeamForname',
                        'userOneSecondTeam.id as userOneSecondTeamId',
                        'userOneSecondTeam.avatar as userOneSecondTeamAvatar',
                        'userOneSecondTeam.email as userOneSecondTeamEmail',
                        'userOneSecondTeam.state as userOneSecondTeamState',
                        'userOneSecondTeam.ending_holiday as userOneSecondTeamEndingHoliday',
                        'userOneSecondTeam.ending_injury as userOneSecondTeamEndingInjury',

                        'userTwoSecondTeam.name as userTwoSecondTeamName',
                        'userTwoSecondTeam.forname as userTwoSecondTeamForname',
                        'userTwoSecondTeam.id as userTwoSecondTeamId',
                        'userTwoSecondTeam.avatar as userTwoSecondTeamAvatar',
                        'userTwoSecondTeam.email as userTwoSecondTeamEmail',
                        'userTwoSecondTeam.state as userTwoSecondTeamState',
                        'userTwoSecondTeam.ending_holiday as userTwoSecondTeamEndingHoliday',
                        'userTwoSecondTeam.ending_injury as userTwoSecondTeamEndingInjury',

                        'rankingSecondTeam.rank as rankSecondTeam',

                        'scores.first_team_win', 'scores.second_team_win', 'firstTeam.id as firstTeamId',
                        'secondTeam.id as secondTeamId',
                        'scores.first_set_first_team', 'scores.first_set_second_team', 'scores.second_set_first_team',
                        'scores.second_set_second_team', 'scores.third_set_first_team', 'scores.third_set_second_team',
                        'scores.my_wo', 'scores.his_wo', 'scores.unplayed',
                        'scores.id as scoreId')
                        ->allScoresDoubleOrMixteInSelectedPool($myPool->id)
                        ->where('firstTeam.id', $myTeam->id)
                        ->where('scores.created_at', '>=', $currentChampionship->start->format('Y-m-d'))
                        ->where('scores.created_at', '<=', $currentChampionship->end->format('Y-m-d'))
                        ->orWhere(function ($query) use ($myTeam, $myPool, $currentChampionship)
                        {
                            $query->allScoresDoubleOrMixteInSelectedPool($myPool->id)
                                ->where('secondTeam.id', $myTeam->id)
                                ->where('scores.created_at', '>=', $currentChampionship->start->format('Y-m-d'))
                                ->where('scores.created_at', '<=', $currentChampionship->end->format('Y-m-d'));
                        })
                        ->get();
                }
            }


            if (count($scores) > 0)
            {

                foreach ($scores as $index => $score)
                {
                    if ($type == 'simple')
                    {
                        $result[$index]['userFirstTeamName'] = $score->userFirstTeamForname .
                            " " . $score->userFirstTeamName;
                        $result[$index]['userFirstTeamId'] = $score->userFirstTeamId;
                        $result[$index]['userFirstTeamAvatar'] = $score->userFirstTeamAvatar;
                        $result[$index]['userFirstTeamEmail'] = $score->userFirstTeamEmail;
                        $result[$index]['userFirstTeamState'] = $score->userFirstTeamState;
                        $userFirstTeamEndingInjury = explode('-', $score->userFirstTeamEndingInjury);
                        $result[$index]['userFirstTeamEndingInjury'] =
                            ucfirst(Date::create($userFirstTeamEndingInjury[0],
                                $userFirstTeamEndingInjury[1],
                                $userFirstTeamEndingInjury[2])->format('l j F'));
                        $userFirstTeamEndingHoliday = explode('-', $score->userFirstTeamEndingHoliday);
                        $result[$index]['userFirstTeamEndingHoliday'] =
                            ucfirst(Date::create($userFirstTeamEndingHoliday[0],
                                $userFirstTeamEndingHoliday[1], $userFirstTeamEndingHoliday[2])->format('l j F'));

                        $result[$index]['userSecondTeamName'] =
                            $score->userSecondTeamForname . " " . $score->userSecondTeamName;
                        $result[$index]['userSecondTeamId'] = $score->userSecondTeamId;
                        $result[$index]['userSecondTeamAvatar'] = $score->userSecondTeamAvatar;
                        $result[$index]['userSecondTeamEmail'] = $score->userSecondTeamEmail;
                        $result[$index]['userSecondTeamState'] = $score->userSecondTeamState;
                        $userSecondTeamEndingInjury = explode('-', $score->userSecondTeamEndingInjury);
                        $result[$index]['userSecondTeamEndingInjury'] =
                            ucfirst(Date::create($userSecondTeamEndingInjury[0], $userSecondTeamEndingInjury[1],
                                $userSecondTeamEndingInjury[2])
                                ->format('l j F'));
                        $userSecondTeamEndingHoliday = explode('-', $score->userSecondTeamEndingHoliday);
                        $result[$index]['userSecondTeamEndingHoliday'] =
                            ucfirst(Date::create($userSecondTeamEndingHoliday[0],
                                $userSecondTeamEndingHoliday[1], $userSecondTeamEndingHoliday[2])
                                ->format('l j F'));

                        $result[$index]['imTheFirstTeam'] = $this->user->id ==
                            $score->userFirstTeamId;
                    }
                    else
                    {
                        $result[$index]['userOneFirstTeamName'] = $score->userOneFirstTeamForname .
                            " " . $score->userOneFirstTeamName;
                        $result[$index]['userOneFirstTeamId'] = $score->userOneFirstTeamId;
                        $result[$index]['userOneFirstTeamAvatar'] = $score->userOneFirstTeamAvatar;
                        $result[$index]['userOneFirstTeamEmail'] = $score->userOneFirstTeamEmail;
                        $result[$index]['userOneFirstTeamState'] = $score->userOneFirstTeamState;
                        $userOneFirstTeamEndingInjury = explode('-', $score->userOneFirstTeamEndingInjury);
                        $result[$index]['userOneFirstTeamEndingInjury'] =
                            ucfirst(Date::create($userOneFirstTeamEndingInjury[0],
                                $userOneFirstTeamEndingInjury[1],
                                $userOneFirstTeamEndingInjury[2])->format('l j F'));
                        $userOneFirstTeamEndingHoliday = explode('-', $score->userOneFirstTeamEndingHoliday);
                        $result[$index]['userOneFirstTeamEndingHoliday'] =
                            ucfirst(Date::create($userOneFirstTeamEndingHoliday[0],
                                $userOneFirstTeamEndingHoliday[1], $userOneFirstTeamEndingHoliday[2])->format('l j F'));

                        $result[$index]['userTwoFirstTeamName'] = $score->userTwoFirstTeamForname .
                            " " . $score->userTwoFirstTeamName;
                        $result[$index]['userTwoFirstTeamId'] = $score->userTwoFirstTeamId;
                        $result[$index]['userTwoFirstTeamAvatar'] = $score->userTwoFirstTeamAvatar;
                        $result[$index]['userTwoFirstTeamEmail'] = $score->userTwoFirstTeamEmail;
                        $result[$index]['userTwoFirstTeamState'] = $score->userTwoFirstTeamState;
                        $userTwoFirstTeamEndingInjury = explode('-', $score->userTwoFirstTeamEndingInjury);
                        $result[$index]['userTwoFirstTeamEndingInjury'] =
                            ucfirst(Date::create($userTwoFirstTeamEndingInjury[0],
                                $userTwoFirstTeamEndingInjury[1],
                                $userTwoFirstTeamEndingInjury[2])->format('l j F'));
                        $userTwoFirstTeamEndingHoliday = explode('-', $score->userTwoFirstTeamEndingHoliday);
                        $result[$index]['userTwoFirstTeamEndingHoliday'] =
                            ucfirst(Date::create($userTwoFirstTeamEndingHoliday[0],
                                $userTwoFirstTeamEndingHoliday[1], $userTwoFirstTeamEndingHoliday[2])->format('l j F'));

                        $result[$index]['userOneSecondTeamName'] = $score->userOneSecondTeamForname .
                            " " . $score->userOneSecondTeamName;
                        $result[$index]['userOneSecondTeamId'] = $score->userOneSecondTeamId;
                        $result[$index]['userOneSecondTeamAvatar'] = $score->userOneSecondTeamAvatar;
                        $result[$index]['userOneSecondTeamEmail'] = $score->userOneSecondTeamEmail;
                        $result[$index]['userOneSecondTeamState'] = $score->userOneSecondTeamState;
                        $userOneSecondTeamEndingInjury = explode('-', $score->userOneSecondTeamEndingInjury);
                        $result[$index]['userOneSecondTeamEndingInjury'] =
                            ucfirst(Date::create($userOneSecondTeamEndingInjury[0],
                                $userOneSecondTeamEndingInjury[1],
                                $userOneSecondTeamEndingInjury[2])->format('l j F'));
                        $userOneSecondTeamEndingHoliday = explode('-', $score->userOneSecondTeamEndingHoliday);
                        $result[$index]['userOneSecondTeamEndingHoliday'] =
                            ucfirst(Date::create($userOneSecondTeamEndingHoliday[0],
                                $userOneSecondTeamEndingHoliday[1], $userOneSecondTeamEndingHoliday[2])->format('l j
                                F'));

                        $result[$index]['userTwoSecondTeamName'] = $score->userTwoSecondTeamForname .
                            " " . $score->userTwoSecondTeamName;
                        $result[$index]['userTwoSecondTeamId'] = $score->userTwoSecondTeamId;
                        $result[$index]['userTwoSecondTeamAvatar'] = $score->userTwoSecondTeamAvatar;
                        $result[$index]['userTwoSecondTeamEmail'] = $score->userTwoSecondTeamEmail;
                        $result[$index]['userTwoSecondTeamState'] = $score->userTwoSecondTeamState;
                        $userTwoSecondTeamEndingInjury = explode('-', $score->userTwoSecondTeamEndingInjury);
                        $result[$index]['userTwoSecondTeamEndingInjury'] =
                            ucfirst(Date::create($userTwoSecondTeamEndingInjury[0],
                                $userTwoSecondTeamEndingInjury[1],
                                $userTwoSecondTeamEndingInjury[2])->format('l j F'));
                        $userTwoSecondTeamEndingHoliday = explode('-', $score->userTwoSecondTeamEndingHoliday);
                        $result[$index]['userTwoSecondTeamEndingHoliday'] =
                            ucfirst(Date::create($userTwoSecondTeamEndingHoliday[0],
                                $userTwoSecondTeamEndingHoliday[1], $userTwoSecondTeamEndingHoliday[2])->format('l j
                                F'));

                        $result[$index]['imTheFirstTeam'] = $this->user->id == $score->userOneFirstTeamId ||
                            $this->user->id == $score->userTwoFirstTeamId;
                    }
                    $result[$index]['firstSetFirstTeam'] = $score->first_set_first_team;
                    $result[$index]['firstSetSecondTeam'] = $score->first_set_second_team;
                    $result[$index]['secondSetFirstTeam'] = $score->second_set_first_team;
                    $result[$index]['secondSetSecondTeam'] = $score->second_set_second_team;
                    $result[$index]['thirdSetFirstTeam'] = $score->third_set_first_team;
                    $result[$index]['thirdSetSecondTeam'] = $score->third_set_second_team;
                    $result[$index]['myWo'] = $score->my_wo;
                    $result[$index]['hisWo'] = $score->his_wo;
                    $result[$index]['unplayed'] = $score->unplayed;
                    $result[$index]['scoreId'] = $score->scoreId;

                    $result[$index]['rankFirstTeam'] = $score->rankFirstTeam;

                    $result[$index]['rankSecondTeam'] = $score->rankSecondTeam;

                    $result[$index]['isFirstTeamWin'] = $score->first_team_win;
                    $result[$index]['isSecondTeamWin'] = $score->second_team_win;

                    $reservation = PlayersReservation::select('players_reservations.date',
                        'time_slots.start', 'courts.number')
                        ->join('time_slots', 'time_slots.id', '=', 'players_reservations.time_slot_id')
                        ->join('courts', 'courts.id', '=', 'players_reservations.court_id')
                        ->where('first_team', $score->firstTeamId)
                        ->where('second_team', $score->secondTeamId)
                        ->where('players_reservations.date', '>=', $currentChampionship->start->format('Y-m-d'))
                        ->where('players_reservations.date', '<=', $currentChampionship->end->format('Y-m-d'))
                        ->orWhere(function ($query) use ($score, $currentChampionship)
                        {
                            $query->where('second_team', $score->firstTeamId)
                                ->where('first_team', $score->secondTeamId)
                                ->where('players_reservations.date', '>=', $currentChampionship->start->format('Y-m-d'))
                                ->where('players_reservations.date', '<=', $currentChampionship->end->format('Y-m-d'));
                        })
                        ->first();

                    $result[$index]['reservation'] = $reservation !== null ?
                        ucfirst(Date::create($reservation->date->year, $reservation->date->month,
                            $reservation->date->day)->format('l j F')) . ' sur le court n° ' .
                        $reservation->number . ' à ' . $reservation->start
                        : null;
                }
            }
        }
        
        return $result;
    }
}
