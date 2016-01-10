<?php

namespace App\Http\Controllers;

use App\Court;
use App\Helpers;
use App\Http\Utilities\Calendar;
use App\PlayersReservation;
use App\Season;
use App\Team;
use App\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReservationController extends Controller
{

    public static function routes($router)
    {
        //patterns
        $router->pattern('date', '^(\d+|(\d{4})-(\d{2})-(\d{2})(.*))$');
        $router->pattern('court_id', '[0-9]+');
        $router->pattern('timeSlot_id', '[0-9]+');

        //reservation list
        $router->get('/index', [
            'uses'       => 'ReservationController@index',
            'as'         => 'reservation.index',
        ]);

        //reservation create
        $router->get('/create/{date}/{court_id}/{timeSlot_id}', [
            'uses'       => 'ReservationController@create',
            'as'         => 'reservation.create',
        ]);

        //reservation create
        $router->post('/create/{date}/{court_id}/{timeSlot_id}', [
            'uses'       => 'ReservationController@store',
            'as'         => 'reservation.store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeSlots = TimeSlot::orderBy('start')->get();
        $courts = Court::orderBy('number')->get();

        $allDays = Calendar::getAllDaysMonth();

        return view('reservation.index', compact('timeSlots', 'courts', 'allDays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($date, $court_id, $timeSlot_id)
    {
        $reservation = new PlayersReservation();
        $court = Court::findOrFail($court_id);

        $myTeams = [];
        $teams = [];

        $myPlayer = Helpers::getInstance()->myPlayer();
        $user = Helpers::getInstance()->auth();
        $seasonActive = Season::active()->first();

        if($myPlayer !== null && $user !== null && $seasonActive !== null)
        {
            //si c'est un court de simple, on prend mon équipe de simple et toutes les autres équipe de simple y
            // compris pas de mon sexe dans le cas ou il n'y aurait pas de championnat simple dame
            if($court !== null && $court->hasType('simple'))
            {
                //mon équipe de simple
                $mySimpleTeam = Team::AllMySimpleTeams($user->gender, $myPlayer->id, $seasonActive->id)->first();
                if($mySimpleTeam !== null)
                {
                    $myTeams[$mySimpleTeam->id] = $mySimpleTeam;
                }

                //équipes de simple dame
                $teams['Simple dame'] = $this->listTeams('woman', 'simple', $myPlayer->id, $seasonActive->id);

                //équipes de simple homme
                $teams['Simple homme'] = $this->listTeams('man', 'simple', $myPlayer->id, $seasonActive->id);

            }
            //si c'est un court de double, on prend mon équipe de double ou de mixte et toutes les autres équipe de
            // double ou de mixte
            elseif($court !== null && $court->hasType('double'))
            {
                //mes équipes de double
                $myDoubleTeam = Team::AllMyDoubleOrMixteActiveTeams('double', $user->gender, $myPlayer->id,
                    $seasonActive->id)->first();
                if($myDoubleTeam !== null)
                {
                    $myTeams[$user->hasGender('man') ? 'Double homme' : 'Double dame'][$myDoubleTeam->id] = $myDoubleTeam->__toString();
                }

                //mes équipes de mixte
                $myMixteTeam = Team::AllMyDoubleOrMixteActiveTeams('mixte', $user->gender === 'man' ? 'woman' :
                    'man', $myPlayer->id, $seasonActive->id)->first();
                if($myMixteTeam !== null)
                {
                    $myTeams['Double mixte'][$myMixteTeam->id] = $myMixteTeam->__toString();
                }

                //toutes les équipes de double dame
                $teams['Double dame'] = $this->listTeams('woman', 'double', $myPlayer->id, $seasonActive->id);

                //toutes les équipes de double homme
                $teams['Double homme'] = $this->listTeams('man', 'double', $myPlayer->id, $seasonActive->id);

                //toutes les équipes de double mixte
                $teams['Double mixte'] = $this->listTeams($user->gender === 'man' ? 'woman' : 'man', 'mixte', $myPlayer->id, $seasonActive->id);
            }
        }

        return view('reservation.create', compact('reservation', 'date', 'court_id', 'timeSlot_id', 'myTeams',
            'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $date, $court_id, $timeSlot_id)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $court = Court::findOrFail($court_id);
        $timeSlot = TimeSlot::findOrFail($timeSlot_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function listTeams($gender, $type, $player_id, $season_id)
    {
        $teams = [];
        $allTeams = null;

        if($type === 'simple')
        {
            $allTeams = Team::AllSimpleTeamsWithoutMe($gender, $player_id, $season_id)
                ->with('playerOne')
                ->with('playerOne.user')
                ->with('playerTwo')
                ->with('playerTwo.user')
                ->get();
        }
        else
        {
            $allTeams = Team::AllDoubleOrMixteActiveTeams($type, $gender, $season_id)
                ->with('playerOne')
                ->with('playerOne.user')
                ->with('playerTwo')
                ->with('playerTwo.user')
                ->get();
        }

        if(count($allTeams) > 0)
        {
            foreach ($allTeams as $team)
            {
                $teams[$team->id] = $team->__toString();
            }
        }
        asort($teams);

        return $teams;
    }
}
