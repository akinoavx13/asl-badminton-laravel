<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\ChampionshipStoreRequest;
use App\Period;
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
        //championship create
        $router->get('create', [
            'uses' => 'ChampionshipController@create',
            'as'   => 'championship.create',
        ]);

        //championship store
        $router->post('store', [
            'uses' => 'ChampionshipController@store',
            'as'   => 'championship.store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if ($activeSeason !== null)
        {
            $lastedPeriod = Period::lasted($activeSeason->id, 'championship')->first();

            if ($lastedPeriod !== null)
            {

                $teams = [];
                $teams['simple'] = $this->getSimpleTeams($activeSeason->id, true);

                $teams['double'] = array_merge($this->getDoubleTeams($activeSeason->id, 'double', 'man', true),
                    $this->getDoubleTeams($activeSeason->id, 'double', 'woman', true));

                $teams['mixte'] = $this->getDoubleTeams($activeSeason->id, 'mixte', '', true);

                return view('championship.create', compact('period', 'teams'));
            }
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

        if ($season !== null)
        {
            Period::create([
                'start'     => $request->start,
                'end'       => $request->end,
                'season_id' => $season->id,
                'type'      => 'championship',
            ]);

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

    private function getSimpleTeams($season_id, $new)
    {
        $simpleTeams = Team::select('users.name', 'users.forname', 'users.state', 'users.ending_holiday',
            'users.ending_injury')
            ->join('players', 'players.id', '=', 'teams.player_one')
            ->join('users', 'players.user_id', '=', 'users.id')
            ->whereNotNull('teams.player_one')
            ->whereNull('teams.player_two')
            ->where('teams.simple_man', true)
            ->where('teams.enable', true)
            ->where('teams.season_id', $season_id)
            ->orWhere(function ($query) use ($season_id)
            {
                $query->whereNotNull('teams.player_one')
                    ->whereNull('teams.player_two')
                    ->where('teams.simple_woman', true)
                    ->where('teams.enable', true)
                    ->where('teams.season_id', $season_id);
            })
            ->orderBy('users.forname', 'asc')
            ->orderBy('users.name', 'asc')
            ->get();

        $playersSimple = [];
        foreach ($simpleTeams as $index => $simpleTeam)
        {
            if ($new)
            {
                $playersSimple[$index]['rank'] = 'new';
            }
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

    private function getDoubleTeams($season_id, $type, $gender, $new)
    {
        $doubleTeams = Team::select('userOne.name as nameOne', 'userOne.forname as fornameOne',
            'userOne.state as stateOne', 'userOne.ending_holiday as ending_holidayOne',
            'userOne.ending_injury as ending_injuryOne', 'userTwo.name as nameTwo', 'userTwo.forname as fornameTwo',
            'userTwo.state as stateTwo', 'userTwo.ending_holiday as ending_holidayTwo',
            'userTwo.ending_injury as ending_injuryTwo')
            ->allDoubleOrMixteActiveTeams($type, $gender, $season_id)
            ->orderBy('userOne.forname', 'asc')
            ->orderBy('userOne.name', 'asc')
            ->get();

        $players = [];

        foreach ($doubleTeams as $index => $doubleTeam)
        {
            if ($new)
            {
                $players[$index]['rank'] = 'new';
            }

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
}
