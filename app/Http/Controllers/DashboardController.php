<?php

namespace App\Http\Controllers;

use App\ChampionshipPool;
use App\Period;
use App\PlayersReservation;
use App\Score;
use App\Season;
use App\Team;
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

        if ($activeSeason !== null)
        {

            $currentChampionship = Period::current($activeSeason->id, 'championship')->first();

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
                    $userID = $this->user->id;
                    return view('dashboard.index', compact('tableReservation', 'pools', 'anchor', 'userID'));
                }
            }
        }

        return redirect()->back()->with('error', 'Tableau de bord indisponible pour le moment !');
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
