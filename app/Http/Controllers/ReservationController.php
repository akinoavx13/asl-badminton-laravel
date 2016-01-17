<?php

namespace App\Http\Controllers;

use App\AdminsReservation;
use App\Court;
use App\Helpers;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Utilities\Calendar;
use App\PlayersReservation;
use App\Season;
use App\Team;
use App\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Collection;
use Jenssegers\Date\Date;

class ReservationController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //patterns
        $router->pattern('date', '^(\d+|(\d{4})-(\d{2})-(\d{2})(.*))$');
        $router->pattern('court_id', '[0-9]+');
        $router->pattern('timeSlot_id', '[0-9]+');

        //reservation list
        $router->get('/index', [
            'uses' => 'ReservationController@index',
            'as'   => 'reservation.index',
        ]);

        //reservation create
        $router->get('/create/{date}/{court_id}/{timeSlot_id}', [
            'uses' => 'ReservationController@create',
            'as'   => 'reservation.create',
        ]);

        //reservation create
        $router->post('/create/{date}/{court_id}/{timeSlot_id}', [
            'uses' => 'ReservationController@store',
            'as'   => 'reservation.store',
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

        $firstDay = new Carbon('first day of this month');

        if($firstDay < Carbon::today())
        {
            $firstDay = Carbon::today();
        }

        $lastDayMonth = new Carbon('last day of this month');

        $playerReservations = PlayersReservation::where('date', '>=', $firstDay)
            ->where('date', '<=', $lastDayMonth)
            ->orderBy('date')
            ->get();

        $reservations = [];

        $courtSimpleAvailable = 0;
        $courtDoubleAvailable = 0;

        foreach ($allDays as $day)
        {
            foreach ($timeSlots as $timeSlot)
            {
                foreach ($courts as $court)
                {
                    if($court->hasType('simple'))
                    {
                        $courtSimpleAvailable ++;
                    }
                    else
                    {
                        $courtDoubleAvailable ++;
                    }

                    $dispo = true;
                    $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id] =
                        "<a href=\"" . route('reservation.create',
                            [$day->format('Y-m-d'), $court->id, $timeSlot->id]) . "\" class=\"text-white\">Réserver</a>";
                    if (count($playerReservations) > 0)
                    {
                        foreach ($playerReservations as $index => $playerReservation)
                        {
                            if ($dispo)
                            {
                                if ($playerReservation->date === $day->format('Y-m-d') && $playerReservation->time_slot_id === $timeSlot->id
                                    && $playerReservation->court_id === $court->id
                                )
                                {
                                    $dispo = false;

                                    //si c'est du simple, je prend que le premier joueur des 2 équipes
                                    if ($court->hasType('simple'))
                                    {
                                        $courtSimpleAvailable --;
                                        $simpleTeams = Team::select('users.forname', 'users.name')
                                            ->join('players', 'players.id', '=', 'teams.player_one')
                                            ->join('users', 'users.id', '=', 'players.user_id')
                                            ->where('teams.id', $playerReservation->first_team)
                                            ->orWhere(function($query) use($playerReservation){
                                                $query->where('teams.id', $playerReservation->second_team);
                                            })
                                            ->take(2)
                                            ->get();

                                        if(count($simpleTeams) === 2)
                                        {
                                            $firstTeam = $simpleTeams[0];
                                            $secondTeam = $simpleTeams[1];
                                            if ($firstTeam !== null && $secondTeam !== null)
                                            {
                                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id] =
                                                    Helpers::getInstance()->getTeamName($firstTeam->forname, $firstTeam->name) . '
                                        <br> VS <br> ' . Helpers::getInstance()->getTeamName($secondTeam->forname,
                                                        $secondTeam->name);
                                            }
                                        }
                                    }
                                    //si c'est du double ou du mixte, je prends le premier et le deuxième joueur des 2 équipes
                                    else
                                    {
                                        $courtDoubleAvailable --;
                                        $doubleOrMixteTeams = Team::select('userOne.forname AS fornameOne',
                                            'userOne.name AS nameOne',
                                            'userTwo.forname AS fornameTwo',
                                            'userTwo.name AS nameTwo')
                                            ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                                            ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                                            ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                                            ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                                            ->where('teams.id', $playerReservation->first_team)
                                            ->orWhere(function($query) use($playerReservation){
                                                $query->where('teams.id', $playerReservation->second_team);
                                            })
                                            ->take(2)
                                            ->get();
                                        if(count($doubleOrMixteTeams) === 2)
                                        {
                                            $firstTeam = $doubleOrMixteTeams[0];
                                            $secondTeam = $doubleOrMixteTeams[1];
                                            if($firstTeam !== null && $secondTeam !== null)
                                            {
                                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id] =
                                                    Helpers::getInstance()->getTeamName($firstTeam->fornameOne,
                                                        $firstTeam->nameOne,
                                                        $firstTeam->fornameTwo, $firstTeam->nameTwo, true) .
                                                    ' <br> VS <br> ' . Helpers::getInstance()->getTeamName($secondTeam->fornameOne,
                                                        $secondTeam->nameOne,
                                                        $secondTeam->fornameTwo, $secondTeam->nameTwo, true);
                                            }
                                        }
                                    }
                                    unset($playerReservations[$index]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return view('reservation.index', compact('timeSlots', 'courts', 'allDays', 'reservations', 'courtSimpleAvailable', 'courtDoubleAvailable'));
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

        $teams = ['Choisir mon adversaire ...'];

        $myPlayer = Helpers::getInstance()->myPlayer();
        $user = $this->user;
        $seasonActive = Season::active()->first();
        if ($myPlayer !== null && $user !== null && $seasonActive !== null)
        {
            //si c'est un court de simple, on prend mon équipe de simple et toutes les autres équipe de simple y
            // compris pas de mon sexe dans le cas ou il n'y aurait pas de championnat simple dame
            if ($court !== null && $court->hasType('simple'))
            {
                //mon équipe de simple
                $mySimpleTeam = Team::select('users.forname', 'users.name', 'teams.id')
                    ->mySimpleTeams($user->gender, $myPlayer->id, $seasonActive->id)->first();
                if ($mySimpleTeam !== null)
                {
                    $myTeams[$mySimpleTeam->id] = Helpers::getInstance()->getTeamName($mySimpleTeam->forname,
                        $mySimpleTeam->name);
                }
                //équipes de simple dame
                $teams['Simple dame'] = $this->listTeams('woman', 'simple', $myPlayer->id, $seasonActive->id);

                //équipes de simple homme
                $teams['Simple homme'] = $this->listTeams('man', 'simple', $myPlayer->id, $seasonActive->id);

            }
            //si c'est un court de double, on prend mon équipe de double ou de mixte et toutes les autres équipe de
            // double ou de mixte
            elseif ($court !== null && $court->hasType('double'))
            {
                $myTeams = ['Choisir mon équipe ...'];
                //mes équipes de double
                $myDoubleTeam = Team::select('userOne.forname AS fornameOne',
                    'userOne.name AS nameOne',
                    'userTwo.forname AS fornameTwo',
                    'userTwo.name AS nameTwo',
                    'teams.id')
                    ->myDoubleOrMixteActiveTeams('double', $user->gender, $myPlayer->id,
                        $seasonActive->id)->first();
                if ($myDoubleTeam !== null)
                {
                    $myTeams[$user->hasGender('man') ? 'Double homme' : 'Double dame'][$myDoubleTeam->id] = Helpers::getInstance()->getTeamName($myDoubleTeam->fornameOne,
                        $myDoubleTeam->nameOne,
                        $myDoubleTeam->fornameTwo, $myDoubleTeam->nameTwo);
                }

                //mes équipes de mixte
                $myMixteTeam = Team::select('userOne.forname AS fornameOne',
                    'userOne.name AS nameOne',
                    'userTwo.forname AS fornameTwo',
                    'userTwo.name AS nameTwo',
                    'teams.id')
                    ->myDoubleOrMixteActiveTeams('mixte', $user->hasGender('man') ? 'woman' :
                        'man', $myPlayer->id, $seasonActive->id)->first();
                if ($myMixteTeam !== null)
                {
                    $myTeams['Double mixte'][$myMixteTeam->id] = Helpers::getInstance()->getTeamName($myMixteTeam->fornameOne,
                        $myMixteTeam->nameOne,
                        $myMixteTeam->fornameTwo, $myMixteTeam->nameTwo);
                }

                if($myDoubleTeam !== null && $myMixteTeam !== null)
                {
                    //toutes les équipes de double dame
                    $teams['Double dame'] = $this->listTeams('woman', 'double', $myPlayer->id, $seasonActive->id, $user->hasGender('man') ? null : $myDoubleTeam);

                    //toutes les équipes de double homme
                    $teams['Double homme'] = $this->listTeams('man', 'double', $myPlayer->id, $seasonActive->id, $user->hasGender('woman') ? null : $myDoubleTeam);

                    //toutes les équipes de double mixte
                    $teams['Double mixte'] = $this->listTeams($user->gender === 'man' ? 'woman' : 'man', 'mixte',
                        $myPlayer->id, $seasonActive->id, $myMixteTeam);

                }
            }
        }

        return view('reservation.create', compact('reservation', 'date', 'court', 'timeSlot_id', 'myTeams',
            'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request, $date, $court_id, $timeSlot_id)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);

        $playerReservationAtThisDay = PlayersReservation::where('date', $date)
            ->where('time_slot_id', $timeSlot_id)
            ->where('court_id', $court_id)
            ->first();

        if($playerReservationAtThisDay === null)
        {
            PlayersReservation::create([
                'date'         => $date,
                'first_team'   => $request->first_team,
                'second_team'  => $request->second_team,
                'user_id'      => $this->user->id,
                'time_slot_id' => $timeSlot_id,
                'court_id'     => $court_id,
            ]);

            return redirect()->route('reservation.index')->with('success', "La réservation a été enregistrée !");
        }

        return redirect()->back()->with('error', "La réservation n'est plus disponible !");

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

    private function listTeams($gender, $type, $player_id, $season_id, $myDoubleOrMixteTeam = null)
    {
        $teams = [];
        $allTeams = null;

        if ($type === 'simple')
        {
            $allTeams = Team::select('users.forname', 'users.name', 'teams.id')
                ->allSimpleTeamsWithoutMe($gender, $player_id, $season_id)
                ->get();
        }
        else
        {
            if($myDoubleOrMixteTeam === null)
            {
                $allTeams = Team::select('userOne.forname AS fornameOne',
                    'userOne.name AS nameOne',
                    'userTwo.forname AS fornameTwo',
                    'userTwo.name AS nameTwo',
                    'teams.id')
                    ->allDoubleOrMixteActiveTeams($type, $gender, $season_id)
                    ->get();
            }
            else
            {
                $allTeams = Team::select('userOne.forname AS fornameOne',
                    'userOne.name AS nameOne',
                    'userTwo.forname AS fornameTwo',
                    'userTwo.name AS nameTwo',
                    'teams.id')
                    ->allDoubleOrMixteActiveTeams($type, $gender, $season_id)
                    ->get();

                $allTeams = $allTeams->reject(function ($item) use ($myDoubleOrMixteTeam) {
                    return $item->id == $myDoubleOrMixteTeam->id;
                });
            }
        }

        if (count($allTeams) > 0)
        {
            foreach ($allTeams as $team)
            {
                if ($type === 'simple')
                {
                    $teams[$team->id] = Helpers::getInstance()->getTeamName($team->forname, $team->name);
                }
                else
                {
                    $teams[$team->id] = Helpers::getInstance()->getTeamName($team->fornameOne, $team->nameOne,
                        $team->fornameTwo, $team->nameTwo);
                }

            }
        }
        asort($teams);

        return $teams;
    }
}
