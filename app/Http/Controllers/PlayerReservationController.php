<?php

namespace App\Http\Controllers;

use App\Court;
use App\Helpers;
use App\Http\Requests;
use App\Http\Requests\PlayerReservationStoreRequest;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Utilities\SendMail;
use App\PlayersReservation;
use App\Season;
use App\Team;
use App\TimeSlot;
use Carbon\Carbon;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Eluceo\iCal\Property\Event\Attendees;
use Illuminate\Support\Facades\File;

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

                if ($myDoubleTeam !== null || $myMixteTeam !== null)
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
     * Store a newly created resource in storage.
     *
     * @param PlayerReservationStoreRequest $request
     * @param $date
     * @param $court_id
     * @param $timeSlot_id
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerReservationStoreRequest $request, $date, $court_id, $timeSlot_id)
    {
        $playerReservationAtThisDay = PlayersReservation::where('date', $date)
            ->where('time_slot_id', $timeSlot_id)
            ->where('court_id', $court_id)
            ->first();

        $date = Carbon::createFromFormat('Y-m-d', $date);

        if ($playerReservationAtThisDay === null)
        {

            $reservation = PlayersReservation::create([
                'date'         => $date,
                'first_team'   => $request->first_team,
                'second_team'  => $request->second_team,
                'user_id'      => $this->user->id,
                'time_slot_id' => $timeSlot_id,
                'court_id'     => $court_id,
            ]);

            $icsCalendar = new Calendar('http://badminton.aslectra.com');
            $icsEvent = new Event();
            $icsAttendees = new Attendees();

            $icsName = "";

            $firstTeam = Team::where('teams.id', $request->first_team)->first();
            if ($firstTeam !== null)
            {
                $firstPlayerFirstTeam = $firstTeam->playerOne;
                $secondPlayerFirstTeam = $firstTeam->playerTwo;
                if ($firstPlayerFirstTeam !== null)
                {
                    $firstUserFirstTeam = $firstPlayerFirstTeam->user;
                    if ($firstUserFirstTeam !== null)
                    {
                        $icsAttendees->add($firstUserFirstTeam->email, ['RSVP' => 'TRUE']);
                        $icsName .= $firstUserFirstTeam->forname . " " . $firstUserFirstTeam->name;
                    }
                }
                if ($secondPlayerFirstTeam !== null)
                {
                    $seconUserFirstTeam = $secondPlayerFirstTeam->user;
                    if ($seconUserFirstTeam !== null)
                    {
                        $icsAttendees->add($seconUserFirstTeam->email, ['RSVP' => 'TRUE']);
                        $icsName .= ' & ' . $seconUserFirstTeam->forname . " " . $seconUserFirstTeam->name;
                    }
                }
            }

            $secondTeam = Team::where('teams.id', $request->second_team)->first();
            if ($secondTeam !== null)
            {
                $firstPlayerSecondTeam = $secondTeam->playerOne;
                $secondPlayerSecondTeam = $secondTeam->playerTwo;
                if ($firstPlayerSecondTeam !== null)
                {
                    $firstUserSecondTeam = $firstPlayerSecondTeam->user;
                    if ($firstUserSecondTeam !== null)
                    {
                        $icsAttendees->add($firstUserSecondTeam->email, ['RSVP' => 'TRUE']);
                        $icsName .= ' VS ' . $firstUserSecondTeam->forname . " " . $firstUserSecondTeam->name;
                    }
                }
                if ($secondPlayerSecondTeam !== null)
                {
                    $seconUserSecondTeam = $secondPlayerSecondTeam->user;
                    if ($seconUserSecondTeam !== null)
                    {
                        $icsAttendees->add($seconUserSecondTeam->email, ['RSVP' => 'TRUE']);
                        $icsName .= ' & ' . $seconUserSecondTeam->forname . " " . $seconUserSecondTeam->name;
                    }
                }
            }

            $timeSlot = TimeSlot::findOrFail($timeSlot_id);
            $court = Court::findOrFail($court_id);

            $start = explode(':', $timeSlot->start);
            $end = explode(':', $timeSlot->end);

            $icsEvent->setSummary($icsName)
                ->setNoTime(false)
                ->setLocation("Court n° " . $court->number)
                ->setAttendees($icsAttendees)
                //->setUseTimezone(true)
                ->setUseUtc(false)
                ->setDtStart(Carbon::create($date->year, $date->month, $date->day, $start[0], $start[1]))
                ->setDtEnd(Carbon::create($date->year, $date->month, $date->day, $end[0], $end[1]));

            $icsCalendar->addComponent($icsEvent);

            $icsFile = fopen(public_path() . "/ics/reservation$reservation->id.ics", 'a');
            File::put(public_path() . "/ics/reservation$reservation->id.ics", $icsCalendar->render());
            fclose($icsFile);

            SendMail::send($this->user, 'reservationCreate', $this->user->attributesToArray(), 'Réservation de court AS
            Lectra Badminton', false,
                asset("ics/reservation$reservation->id.ics"));

            unlink(public_path() . "/ics/reservation$reservation->id.ics");

            return redirect()->route('reservation.index')->with('success', "La réservation a été enregistrée !");
        }

        return redirect()->back()->with('error', "La réservation n'est plus disponible !");

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
