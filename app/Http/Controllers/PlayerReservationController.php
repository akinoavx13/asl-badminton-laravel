<?php

namespace App\Http\Controllers;

use App\Court;
use App\Helpers;
use App\Http\Requests\ReservationStoreRequest;
use App\PlayersReservation;
use App\Season;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class PlayerReservationController extends Controller
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
        $router->pattern('playerReservation_id', '[0-9]+');

        //player reservation create
        $router->get('/create/{date}/{court_id}/{timeSlot_id}', [
            'uses' => 'PlayerReservationController@create',
            'as'   => 'playerReservation.create',
        ]);

        //player reservation store
        $router->post('/create/{date}/{court_id}/{timeSlot_id}', [
            'uses' => 'PlayerReservationController@store',
            'as'   => 'playerReservation.store',
        ]);

        //player reservation delete
        $router->get('/delete/{playerReservation_id}', [
            'middleware' => ['admin'],
            'uses'       => 'PlayerReservationController@delete',
            'as'         => 'playerReservation.delete',
        ]);
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

                if ($myDoubleTeam !== null && $myMixteTeam !== null)
                {
                    //toutes les équipes de double dame
                    $teams['Double dame'] = $this->listTeams('woman', 'double', $myPlayer->id, $seasonActive->id,
                        $user->hasGender('man') ? null : $myDoubleTeam);

                    //toutes les équipes de double homme
                    $teams['Double homme'] = $this->listTeams('man', 'double', $myPlayer->id, $seasonActive->id,
                        $user->hasGender('woman') ? null : $myDoubleTeam);

                    //toutes les équipes de double mixte
                    $teams['Double mixte'] = $this->listTeams($user->gender === 'man' ? 'woman' : 'man', 'mixte',
                        $myPlayer->id, $seasonActive->id, $myMixteTeam);

                }
            }
        }

        return view('playerReservation.create', compact('reservation', 'date', 'court', 'timeSlot_id', 'myTeams',
            'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationStoreRequest|Request $request
     * @param $date
     * @param $court_id
     * @param $timeSlot_id
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request, $date, $court_id, $timeSlot_id)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);

        $playerReservationAtThisDay = PlayersReservation::where('date', $date)
            ->where('time_slot_id', $timeSlot_id)
            ->where('court_id', $court_id)
            ->first();

        if ($playerReservationAtThisDay === null)
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
            if ($myDoubleOrMixteTeam === null)
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

                $allTeams = $allTeams->reject(function ($item) use ($myDoubleOrMixteTeam)
                {
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

    /**
     * Delete the selected user
     *
     * @param $playerReservation_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($playerReservation_id)
    {
        $playerReservation = PlayersReservation::findOrFail($playerReservation_id);
        $playerReservation->delete();

        return redirect()->back()->with('success', "La réservation vient d'être supprimée !");
    }

}
