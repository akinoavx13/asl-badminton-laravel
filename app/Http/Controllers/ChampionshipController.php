<?php

namespace App\Http\Controllers;

use App\ChampionshipPool;
use App\ChampionshipRanking;
use App\Helpers;
use App\Http\Requests\ChampionshipStoreRequest;
use App\Period;
use App\Score;
use App\Season;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;

class ChampionshipController extends Controller
{

    /**
     * @param $router
     */
    public static function routes($router)
    {

        //championship index
        $router->get('index', [
            'middleware' => 'settingExists',
            'uses'       => 'ChampionshipController@index',
            'as'         => 'championship.index',
        ]);

        //championship create
        $router->get('create', [
            'middleware' => 'settingExists',
            'uses'       => 'ChampionshipController@create',
            'as'         => 'championship.create',
        ]);

        //championship store
        $router->post('store', [
            'middleware' => 'settingExists',
            'uses'       => 'ChampionshipController@store',
            'as'         => 'championship.store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $activeSeason = Season::active()->first();

        if ($activeSeason !== null)
        {
            $setting = Helpers::getInstance()->setting();

            $championship = Period::current($activeSeason->id, 'championship')->first();

            $teams = [];

            if($championship !== null)
            {
                if ($setting->hasChampionshipSimpleWoman(true))
                {
                    $teams['simple']['man'] = $this->getSimpleTeamsViews($activeSeason->id, $championship->id, 'man');
                    $teams['simple']['woman'] = $this->getSimpleTeamsViews($activeSeason->id, $championship->id, 'woman');
                }
                else
                {
                    $teams['simple'] = $this->getSimpleTeamsViews($activeSeason->id, $championship->id, '', true);
                }

                if ($setting->hasChampionshipDoubleWoman(true))
                {
                    $teams['double']['man'] = $this->getDoubleOrMixteTeamsViews($activeSeason->id, $championship->id,
                        'double', 'man');
                    $teams['double']['woman'] = $this->getDoubleOrMixteTeamsViews($activeSeason->id, $championship->id,
                        'double', 'woman');
                }
                else
                {
                    $teams['double'] = $this->getDoubleOrMixteTeamsViews($activeSeason->id, $championship->id, 'double', '',
                        true);
                }

                $teams['mixte'] = $this->getDoubleOrMixteTeamsViews($activeSeason->id, $championship->id, 'mixte', '');

                return view('championship.index', compact('championship', 'teams', 'setting'));
            }
            else
            {
                return redirect()->route('home.index')->with('error', "Il n'y a pas de championnat pour le moment !");
            }
        }

        return redirect()->route('season.index')->with('error', "Le championnat ne peut pas être créé car il n'y a
        pas de saison active !");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $period = new Period();

        $activeSeason = Season::active()->first();

        $setting = Helpers::getInstance()->setting();

        if ($activeSeason !== null)
        {
            $lastedPeriod = Period::lasted($activeSeason->id, 'championship')->first();

            $teams = [];
            $poolsNumber = [];
            if ($setting->hasChampionshipSimpleWoman(true))
            {
                $teams['simple']['man'] = $this->getSimpleTeams($activeSeason->id, 'man');
                $poolsNumber['simple']['man'] = $this->getNumberOfPool($teams['simple']['man']);

                $teams['simple']['woman'] = $this->getSimpleTeams($activeSeason->id, 'woman');
                $poolsNumber['simple']['woman'] = $this->getNumberOfPool($teams['simple']['woman']);

            }
            else
            {
                $teams['simple'] = array_merge($this->getSimpleTeams($activeSeason->id, 'man'),
                    $this->getSimpleTeams($activeSeason->id, 'woman'));
                sort($teams['simple']);
                $poolsNumber['simple'] = $this->getNumberOfPool($teams['simple']);

            }

            if ($setting->hasChampionshipDoubleWoman(true))
            {
                $teams['double']['man'] = $this->getDoubleTeams($activeSeason->id, 'double', 'man');
                $poolsNumber['double']['man'] = $this->getNumberOfPool($teams['double']['man']);

                $teams['double']['woman'] = $this->getDoubleTeams($activeSeason->id, 'double', 'woman');
                $poolsNumber['double']['woman'] = $this->getNumberOfPool($teams['double']['woman']);

            }
            else
            {
                $teams['double'] = array_merge($this->getDoubleTeams($activeSeason->id, 'double', 'man'),
                    $this->getDoubleTeams($activeSeason->id, 'double', 'woman'));
                sort($teams['double']);
                $poolsNumber['double'] = $this->getNumberOfPool($teams['double']);

            }

            $teams['mixte'] = $this->getDoubleTeams($activeSeason->id, 'mixte', '');
            $poolsNumber['mixte'] = $this->getNumberOfPool($teams['mixte']);

            if ($lastedPeriod !== null)
            {
                if ($setting->hasChampionshipSimpleWoman(true))
                {
                    $teams['simple']['man'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                        $teams['simple']['man'], 'simple', 'man');
                    $poolsNumber['simple']['man'] = $this->getNumberOfPool($teams['simple']['man']);


                    $teams['simple']['woman'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                        $teams['simple']['woman'], 'simple', 'woman');
                    $poolsNumber['simple']['woman'] = $this->getNumberOfPool($teams['simple']['woman']);

                }
                else
                {
                    $teams['simple'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                        $teams['simple'], 'simple', '', true);
                    $poolsNumber['simple'] = $this->getNumberOfPool($teams['simple']);

                }

                if ($setting->hasChampionshipDoubleWoman(true))
                {

                    $teams['double']['man'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                        $teams['double']['man'], 'double', 'man');
                    $poolsNumber['double']['woman'] = $this->getNumberOfPool($teams['double']['woman']);

                    $teams['double']['woman'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                        $teams['double']['woman'], 'double', 'woman');
                    $poolsNumber['double']['woman'] = $this->getNumberOfPool($teams['double']['woman']);

                }
                else
                {
                    $teams['double'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                        $teams['double'], 'double', '', true);
                    $poolsNumber['double'] = $this->getNumberOfPool($teams['double']);

                }

                $teams['mixte'] = $this->getTeamsLastedChampionship($lastedPeriod->id, $activeSeason->id,
                    $teams['mixte'], 'mixte', '');
                $poolsNumber['mixte'] = $this->getNumberOfPool($teams['mixte']);

            }

            return view('championship.create', compact('period', 'teams', 'setting', 'poolsNumber'));
        }

        return redirect()->route('season.index')->with('error', "Le championnat ne peut pas être créé car il n'y a
        pas de saison active !");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ChampionshipStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChampionshipStoreRequest $request)
    {

        $season = Season::active()->first();

        $setting = Helpers::getInstance()->setting();
        $championshipSimpleWoman = $setting->hasChampionshipSimpleWoman(true) ? true : false;
        $championshipDoubleWoman = $setting->hasChampionshipDoubleWoman(true) ? true : false;

        if ($season !== null)
        {
            $period = Period::create([
                'start'     => $request->start,
                'end'       => $request->end,
                'season_id' => $season->id,
                'type'      => 'championship',
            ]);

            $pools = [];

            if ($championshipSimpleWoman)
            {
                $pools['simple_man'] = $this->initPoolsTable($request->pool_number_simple_man,
                    $request->exists('pool_number_simple_man'));

                $pools['simple_woman'] = $this->initPoolsTable($request->pool_number_simple_woman,
                    $request->exists('pool_number_simple_woman'));
            }
            else
            {
                $pools['simple'] = $this->initPoolsTable($request->pool_number_simple,
                    $request->exists('pool_number_simple'));
            }

            if ($championshipDoubleWoman)
            {
                $pools['double_man'] = $this->initPoolsTable($request->pool_number_double_man,
                    $request->exists('pool_number_double_man'));

                $pools['double_woman'] = [];
                $this->initPoolsTable($request->pool_number_double_woman, $request->exists('pool_number_double_woman'));
            }
            else
            {
                $pools['double'] = $this->initPoolsTable($request->pool_number_double,
                    $request->exists('pool_number_double'));
            }

            $pools['mixte'] = $this->initPoolsTable($request->pool_number_mixte, $request->exists('pool_number_mixte'));

            if ($championshipSimpleWoman)
            {
                foreach (['simple_man', 'simple_woman'] as $gender)
                {
                    $this->createPoolsAndRanks($pools[$gender], $gender, $period->id);
                    $this->createScores($pools[$gender]);
                }
            }
            else
            {
                $this->createPoolsAndRanks($pools['simple'], 'simple', $period->id);
                $this->createScores($pools['simple']);
            }

            if ($championshipDoubleWoman)
            {
                foreach (['double_man', 'double_woman'] as $gender)
                {
                    $this->createPoolsAndRanks($pools[$gender], $gender, $period->id);
                    $this->createScores($pools[$gender]);
                }
            }
            else
            {
                $this->createPoolsAndRanks($pools['double'], 'double', $period->id);
                $this->createScores($pools['double']);
            }

            $this->createPoolsAndRanks($pools['mixte'], 'mixte', $period->id);
            $this->createScores($pools['mixte']);

            return redirect()->route('home.index')->with('success', "Le championnat vient d'être créé !");
        }

        return redirect()->route('season.index')->with('error', "Le championnat ne peut pas être créé car il n'y a
        pas de saison active !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getSimpleTeams($season_id, $gender)
    {
        $simpleTeams = Team::select('users.name', 'users.forname', 'users.state', 'users.ending_holiday',
            'users.ending_injury', 'teams.id')
            ->allSimpleTeams($gender, $season_id)
            ->orderBy('users.forname')
            ->orderBy('users.name')
            ->get();

        $playersSimple = [];
        foreach ($simpleTeams as $index => $simpleTeam)
        {
            $playersSimple[$index]['rank'] = 'new';
            $playersSimple[$index]['id'] = $simpleTeam->id;
            $playersSimple[$index]['name'] = Helpers::getInstance()->getTeamName($simpleTeam->forname,
                $simpleTeam->name);
            $playersSimple[$index]['state'] = $simpleTeam->state;
            $playersSimple[$index]['ending_holiday'] = Date::createFromFormat('Y-m-d', $simpleTeam->ending_holiday)
                ->format('l j F Y');
            $playersSimple[$index]['ending_injury'] = Date::createFromFormat('Y-m-d', $simpleTeam->ending_injury)
                ->format('l j F Y');;
        }

        return $playersSimple;
    }

    private function getSimpleTeamsLastedChampionship($lastedPeriod_id, $activeSeason_id, $gender, $twice = false)
    {

        if ($twice)
        {
            $simpleTeams = Team::select('users.name', 'users.forname', 'users.state', 'users.ending_holiday',
                'users.ending_injury', 'teams.id', 'championship_rankings.rank', 'championship_pools.number')
                ->allSimpleTeamsLastedChampionshipNoGender($lastedPeriod_id, $activeSeason_id)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }
        else
        {
            $simpleTeams = Team::select('users.name', 'users.forname', 'users.state', 'users.ending_holiday',
                'users.ending_injury', 'teams.id', 'championship_rankings.rank', 'championship_pools.number')
                ->allSimpleTeamsLastedChampionship($lastedPeriod_id, $activeSeason_id, $gender)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }


        $playersSimple = [];
        foreach ($simpleTeams as $index => $simpleTeam)
        {
            $playersSimple[$index]['pool_number'] = $simpleTeam->number;
            $playersSimple[$index]['rank'] = $simpleTeam->rank;
            $playersSimple[$index]['id'] = $simpleTeam->id;
            $playersSimple[$index]['name'] = Helpers::getInstance()->getTeamName($simpleTeam->forname,
                $simpleTeam->name);
            $playersSimple[$index]['state'] = $simpleTeam->state;
            $playersSimple[$index]['ending_holiday'] = Date::createFromFormat('Y-m-d', $simpleTeam->ending_holiday)
                ->format('l j F Y');
            $playersSimple[$index]['ending_injury'] = Date::createFromFormat('Y-m-d', $simpleTeam->ending_injury)
                ->format('l j F Y');;
        }

        return $playersSimple;
    }

    private function getDoubleTeams($season_id, $type, $gender)
    {
        $doubleTeams = Team::select('userOne.name as nameOne', 'userOne.forname as fornameOne',
            'userOne.state as stateOne', 'userOne.ending_holiday as ending_holidayOne',
            'userOne.ending_injury as ending_injuryOne', 'userTwo.name as nameTwo', 'userTwo.forname as fornameTwo',
            'userTwo.state as stateTwo', 'userTwo.ending_holiday as ending_holidayTwo',
            'userTwo.ending_injury as ending_injuryTwo', 'teams.id')
            ->allDoubleOrMixteActiveTeams($type, $gender, $season_id)
            ->orderBy('userOne.forname')
            ->orderBy('userOne.name')
            ->get();

        $players = [];

        foreach ($doubleTeams as $index => $doubleTeam)
        {
            $players[$index]['rank'] = 'new';
            $players[$index]['id'] = $doubleTeam->id;
            $players[$index]['name'] = Helpers::getInstance()->getTeamName($doubleTeam->fornameOne,
                $doubleTeam->nameOne, $doubleTeam->fornameTwo, $doubleTeam->nameTwo);
            $players[$index]['stateOne'] = $doubleTeam->stateOne;
            $players[$index]['stateTwo'] = $doubleTeam->stateTwo;
            $players[$index]['ending_holidayOne'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_holidayOne)->format('l j F Y');
            $players[$index]['ending_holidayTwo'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_holidayTwo)->format('l j F Y');
            $players[$index]['ending_injuryOne'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_injuryOne)->format('l j F Y');
            $players[$index]['ending_injuryTwo'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_injuryTwo)->format('l j F Y');
        }

        return $players;
    }


    private function getDoubleOrMixteTeamsLastedChampionship($type, $gender, $lastedPeriod_id, $season_id, $twice = false)
    {

        if($twice)
        {
            $doubleTeams = Team::select('userOne.name as nameOne', 'userOne.forname as fornameOne',
                'userOne.state as stateOne', 'userOne.ending_holiday as ending_holidayOne',
                'userOne.ending_injury as ending_injuryOne', 'userTwo.name as nameTwo', 'userTwo.forname as fornameTwo',
                'userTwo.state as stateTwo', 'userTwo.ending_holiday as ending_holidayTwo',
                'userTwo.ending_injury as ending_injuryTwo', 'teams.id', 'championship_rankings.rank',
                'championship_pools.number')
                ->allDoubleOrMixteTeamsLastedChampionshipNoGender($type, $lastedPeriod_id, $season_id)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }
        else
        {
            $doubleTeams = Team::select('userOne.name as nameOne', 'userOne.forname as fornameOne',
                'userOne.state as stateOne', 'userOne.ending_holiday as ending_holidayOne',
                'userOne.ending_injury as ending_injuryOne', 'userTwo.name as nameTwo', 'userTwo.forname as fornameTwo',
                'userTwo.state as stateTwo', 'userTwo.ending_holiday as ending_holidayTwo',
                'userTwo.ending_injury as ending_injuryTwo', 'teams.id', 'championship_rankings.rank',
                'championship_pools.number')
                ->allDoubleOrMixteTeamsLastedChampionship($type, $gender, $lastedPeriod_id, $season_id)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }

        $players = [];

        foreach ($doubleTeams as $index => $doubleTeam)
        {
            $players[$index]['pool_number'] = $doubleTeam->number;
            $players[$index]['rank'] = $doubleTeam->rank;
            $players[$index]['id'] = $doubleTeam->id;
            $players[$index]['name'] = Helpers::getInstance()->getTeamName($doubleTeam->fornameOne,
                $doubleTeam->nameOne, $doubleTeam->fornameTwo, $doubleTeam->nameTwo);
            $players[$index]['stateOne'] = $doubleTeam->stateOne;
            $players[$index]['stateTwo'] = $doubleTeam->stateTwo;
            $players[$index]['ending_holidayOne'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_holidayOne)->format('l j F Y');
            $players[$index]['ending_holidayTwo'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_holidayTwo)->format('l j F Y');
            $players[$index]['ending_injuryOne'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_injuryOne)->format('l j F Y');
            $players[$index]['ending_injuryTwo'] = Date::createFromFormat('Y-m-d',
                $doubleTeam->ending_injuryTwo)->format('l j F Y');
        }

        return $players;
    }

    private function createPoolsAndRanks($pools, $gender, $period_id)
    {
        foreach ($pools as $pool_number => $teams_id)
        {
            $pool = ChampionshipPool::create([
                'number'    => $pool_number,
                'type'      => $gender,
                'period_id' => $period_id,
            ]);

            foreach ($teams_id as $team_id)
            {
                ChampionshipRanking::create([
                    'match_to_play'        => count($pools[$pool_number]) - 1,
                    'team_id'              => $team_id,
                    'championship_pool_id' => $pool->id,
                ]);
            }
        }
    }

    private function initPoolsTable($teams, $exist)
    {
        $pools = [];

        if ($exist)
        {
            foreach ($teams as $team_id => $pool_number)
            {
                $pools[$pool_number][] = $team_id;
            }
        }

        return $pools;
    }

    private function createScores($pools)
    {
        foreach ($pools as $pool_number => $pool)
        {
            foreach ($pool as $first_index => $first_team_id)
            {
                foreach ($pool as $second_index => $second_team_id)
                {
                    if ($first_index <= $second_index && $first_team_id !== $second_team_id)
                    {
                        Score::create([
                            'first_team_id'  => $first_team_id,
                            'second_team_id' => $second_team_id,
                        ]);
                    }
                }
            }
        }
    }

    private function getTeamsLastedChampionship($lastedPeriod_id, $season_id, $teams, $type, $gender, $combine = false)
    {
        if ($type === 'simple')
        {
            if (! $combine)
            {
                $teamsLastedChampionship = $this->getSimpleTeamsLastedChampionship($lastedPeriod_id, $season_id,
                    $gender);
            }
            else
            {
                $teamsLastedChampionship = $this->getSimpleTeamsLastedChampionship($lastedPeriod_id,
                    $season_id, '', true);
            }
        }
        elseif ($type === 'double')
        {
            if (! $combine)
            {
                $teamsLastedChampionship = $this->getDoubleOrMixteTeamsLastedChampionship('double', $gender,
                    $lastedPeriod_id, $season_id);
            }
            else
            {
                $teamsLastedChampionship = $this->getDoubleOrMixteTeamsLastedChampionship('double', '',
                    $lastedPeriod_id, $season_id, true);
            }

        }
        else
        {
            $teamsLastedChampionship = $this->getDoubleOrMixteTeamsLastedChampionship('mixte', $gender,
                $lastedPeriod_id, $season_id);
        }
        foreach ($teams as $team)
        {
            $exist = false;
            foreach ($teamsLastedChampionship as $lastedChampionship)
            {
                if ($team['id'] == $lastedChampionship['id'])
                {
                    $exist = true;
                }
            }
            if (! $exist)
            {
                array_push($teamsLastedChampionship, $team);
            }
        }

        if ($combine)
        {
            return $teamsLastedChampionship;
        }
        else
        {
            return $this->array_sort($teamsLastedChampionship, 'rank');
        }
    }

    private function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = [];
        $sortable_array = [];

        if (count($array) > 0)
        {
            foreach ($array as $k => $v)
            {
                if (is_array($v))
                {
                    foreach ($v as $k2 => $v2)
                    {
                        if ($k2 == $on)
                        {
                            $sortable_array[$k] = $v2;
                        }
                    }
                }
                else
                {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order)
            {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v)
            {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    private function getNumberOfPool($teams)
    {
        $numberOfPlayers = count($teams);
        $quotient = floor($numberOfPlayers / 3);
        $rest = $numberOfPlayers % 3;

        $numberPoolsOf4 = $rest + floor(($quotient - $rest) / 4) * 3;
        $numberPoolsOf3 = ($quotient - $rest) % 4;

        $number = [
            '3' => $numberPoolsOf3,
            '4' => $numberPoolsOf4,
        ];

        return $number;
    }

    private function getSimpleTeamsViews($season_id, $lastedPeriod_id, $gender, $twice = false)
    {
        $playersSimple = [];

        if ($twice)
        {
            $simpleTeams = Team::select('users.name', 'users.forname', 'championship_rankings.rank',
                'championship_pools.number', 'championship_rankings.total_points', 'championship_rankings.match_played',
                'championship_rankings.match_to_play', 'championship_rankings.match_won',
                'championship_rankings.match_lost', 'championship_rankings.match_unplayed',
                'championship_rankings.match_won_by_wo', 'championship_rankings.match_lost_by_wo',
                'championship_rankings.total_difference_set', 'championship_rankings.total_difference_points',
                'users.id')
                ->allSimpleTeamsLastedChampionshipNoGender($lastedPeriod_id, $season_id)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }
        else
        {
            $simpleTeams = Team::select('users.name', 'users.forname', 'championship_rankings.rank',
                'championship_pools.number', 'championship_rankings.total_points', 'championship_rankings.match_played',
                'championship_rankings.match_to_play', 'championship_rankings.match_won',
                'championship_rankings.match_lost', 'championship_rankings.match_unplayed',
                'championship_rankings.match_won_by_wo', 'championship_rankings.match_lost_by_wo',
                'championship_rankings.total_difference_set', 'championship_rankings.total_difference_points',
                'users.id')
                ->allSimpleTeamsLastedChampionship($lastedPeriod_id, $season_id, $gender)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }

        foreach ($simpleTeams as $index => $simpleTeam)
        {
            $playersSimple[$simpleTeam->number][$index]['rank'] = $simpleTeam->rank;
            $playersSimple[$simpleTeam->number][$index]['name'] = Helpers::getInstance()->getTeamName($simpleTeam->forname,
                $simpleTeam->name);
            $playersSimple[$simpleTeam->number][$index]['points'] = $simpleTeam->total_points;
            $playersSimple[$simpleTeam->number][$index]['matchs'] = $simpleTeam->match_played . '/' . $simpleTeam->match_to_play;
            $playersSimple[$simpleTeam->number][$index]['match_won'] = $simpleTeam->match_won;
            $playersSimple[$simpleTeam->number][$index]['match_lost'] = $simpleTeam->match_lost;
            $playersSimple[$simpleTeam->number][$index]['match_unplayed'] = $simpleTeam->match_unplayed;
            $playersSimple[$simpleTeam->number][$index]['match_won_by_wo'] = $simpleTeam->match_won_by_wo;
            $playersSimple[$simpleTeam->number][$index]['match_lost_by_wo'] = $simpleTeam->match_lost_by_wo;
            $playersSimple[$simpleTeam->number][$index]['total_difference_set'] = $simpleTeam->total_difference_set;
            $playersSimple[$simpleTeam->number][$index]['total_difference_points'] = $simpleTeam->total_difference_points;
            $playersSimple[$simpleTeam->number][$index]['user_id'] = $simpleTeam->id;
        }

        return $playersSimple;
    }

    private function getDoubleOrMixteTeamsViews($season_id, $lastedPeriod_id, $type, $gender, $twice = false)
    {
        $playersDouble = [];

        if ($twice)
        {
            $doubleTeams = Team::select('userOne.name as nameOne', 'userOne.forname as fornameOne',
                'userTwo.name as nameTwo', 'userTwo.forname as fornameTwo', 'championship_rankings.rank',
                'championship_pools.number', 'championship_rankings.total_points', 'championship_rankings.match_played',
                'championship_rankings.match_to_play',
                'championship_rankings.match_won', 'championship_rankings.match_lost',
                'championship_rankings.match_unplayed', 'championship_rankings.match_won_by_wo',
                'championship_rankings.match_lost_by_wo', 'championship_rankings.total_difference_set',
                'championship_rankings.total_difference_points', 'userOne.id as userOne_id',
                'userTwo.id as userTwo_id')
                ->allDoubleOrMixteTeamsLastedChampionshipNoGender($type, $lastedPeriod_id, $season_id)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }
        else
        {
            $doubleTeams = Team::select('userOne.name as nameOne', 'userOne.forname as fornameOne',
                'userTwo.name as nameTwo', 'userTwo.forname as fornameTwo', 'championship_rankings.rank',
                'championship_pools.number', 'championship_rankings.total_points', 'championship_rankings.match_played',
                'championship_rankings.match_to_play',
                'championship_rankings.match_won', 'championship_rankings.match_lost',
                'championship_rankings.match_unplayed', 'championship_rankings.match_won_by_wo',
                'championship_rankings.match_lost_by_wo', 'championship_rankings.total_difference_set',
                'championship_rankings.total_difference_points', 'userOne.id as userOne_id',
                'userTwo.id as userTwo_id')
                ->allDoubleOrMixteTeamsLastedChampionship($type, $gender, $lastedPeriod_id, $season_id)
                ->orderBy('championship_pools.number')
                ->orderBy('championship_rankings.rank')
                ->get();
        }

        foreach ($doubleTeams as $index => $doubleTeam)
        {
            $playersDouble[$doubleTeam->number][$index]['rank'] = $doubleTeam->rank;
            $playersDouble[$doubleTeam->number][$index]['name'] = Helpers::getInstance()->getTeamName($doubleTeam->fornameOne,
                $doubleTeam->nameOne, $doubleTeam->fornameTwo, $doubleTeam->nameTwo);
            $playersDouble[$doubleTeam->number][$index]['points'] = $doubleTeam->total_points;
            $playersDouble[$doubleTeam->number][$index]['matchs'] = $doubleTeam->match_played . '/' . $doubleTeam->match_to_play;
            $playersDouble[$doubleTeam->number][$index]['match_won'] = $doubleTeam->match_won;
            $playersDouble[$doubleTeam->number][$index]['match_lost'] = $doubleTeam->match_lost;
            $playersDouble[$doubleTeam->number][$index]['match_unplayed'] = $doubleTeam->match_unplayed;
            $playersDouble[$doubleTeam->number][$index]['match_won_by_wo'] = $doubleTeam->match_won_by_wo;
            $playersDouble[$doubleTeam->number][$index]['match_lost_by_wo'] = $doubleTeam->match_lost_by_wo;
            $playersDouble[$doubleTeam->number][$index]['total_difference_set'] = $doubleTeam->total_difference_set;
            $playersDouble[$doubleTeam->number][$index]['total_difference_points'] = $doubleTeam->total_difference_points;
            $playersDouble[$doubleTeam->number][$index]['userOne_id'] = $doubleTeam->userOne_id;
            $playersDouble[$doubleTeam->number][$index]['userTwo_id'] = $doubleTeam->userTwo_id;
        }

        return $playersDouble;
    }

}
