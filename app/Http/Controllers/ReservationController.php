<?php

namespace App\Http\Controllers;

use App\AdminsReservation;
use App\Court;
use App\Helpers;
use App\Http\Utilities\Calendar;
use App\PlayersReservation;
use App\Team;
use App\TimeSlot;
use Carbon\Carbon;
use App\Http\Requests;
use Jenssegers\Date\Date;


class ReservationController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //reservation list
        $router->get('index', [
            'uses' => 'ReservationController@index',
            'as'   => 'reservation.index',
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

        $courtType = [];

        foreach ($courts as $court)
        {
            $court->hasType('simple') ? $courtType[$court->id] = 'simple' : $courtType[$court->id] = 'double';
        }

        $allDays = Calendar::getAllDaysMonth();

        $firstDay = new Carbon('first day of this month');

        if ($firstDay < Carbon::today())
        {
            $firstDay = Carbon::today();
        }

        $lastDayMonth = end($allDays);

        $playerReservations = PlayersReservation::where('date', '>=', $firstDay)
            ->where('date', '<=', $lastDayMonth)
            ->orderBy('date')
            ->get();

        $adminReservations = AdminsReservation::where('start', '>=', $firstDay)
            ->orWhere(function ($query) use ($lastDayMonth)
            {
                $query->where('end', '<=', $lastDayMonth);
            })
            ->orderBy('start')
            ->get();

        $reservations = [];

        $courtSimpleAvailable = 0;
        $courtDoubleAvailable = 0;

        if (count($playerReservations) > 0)
        {
            foreach ($playerReservations as $index => $playerReservation)
            {
                //si c'est du simple, je prend que le premier joueur des 2 équipes
                if ($courtType[$playerReservation->court_id] === 'simple')
                {
                    $courtSimpleAvailable--;
                    $simpleTeams = Team::select('users.forname', 'users.name')
                        ->join('players', 'players.id', '=', 'teams.player_one')
                        ->join('users', 'users.id', '=', 'players.user_id')
                        ->where('teams.id', $playerReservation->first_team)
                        ->orWhere(function ($query) use ($playerReservation)
                        {
                            $query->where('teams.id', $playerReservation->second_team);
                        })
                        ->take(2)
                        ->get();

                    if (count($simpleTeams) === 2)
                    {
                        $firstTeam = $simpleTeams[0];
                        $secondTeam = $simpleTeams[1];
                        if ($firstTeam !== null && $secondTeam !== null)
                        {
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['first_team'] = Helpers::getInstance()->getTeamName
                            ($firstTeam->forname, $firstTeam->name);
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['second_team'] = Helpers::getInstance()->getTeamName($secondTeam->forname,
                                $secondTeam->name);
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['user_id'] = $playerReservation->user_id;
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['reservation_id'] = $playerReservation->id;
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['type'] = 'simple';
                        }
                    }
                }
                //si c'est du double ou du mixte, je prends le premier et le deuxième joueur des 2 équipes
                else
                {
                    $courtDoubleAvailable--;
                    $doubleOrMixteTeams = Team::select('userOne.forname AS fornameOne',
                        'userOne.name AS nameOne',
                        'userTwo.forname AS fornameTwo',
                        'userTwo.name AS nameTwo')
                        ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                        ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                        ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                        ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                        ->where('teams.id', $playerReservation->first_team)
                        ->orWhere(function ($query) use ($playerReservation)
                        {
                            $query->where('teams.id', $playerReservation->second_team);
                        })
                        ->take(2)
                        ->get();
                    if (count($doubleOrMixteTeams) === 2)
                    {
                        $firstTeam = $doubleOrMixteTeams[0];
                        $secondTeam = $doubleOrMixteTeams[1];
                        if ($firstTeam !== null && $secondTeam !== null)
                        {
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['first_team'] =
                                Helpers::getInstance()->getTeamName($firstTeam->fornameOne, $firstTeam->nameOne,
                                    $firstTeam->fornameTwo, $firstTeam->nameTwo, true);
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['second_team'] = Helpers::getInstance()->getTeamName($secondTeam->fornameOne,
                                $secondTeam->nameOne, $secondTeam->fornameTwo, $secondTeam->nameTwo, true);
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['user_id'] = $playerReservation->user_id;
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['reservation_id'] = $playerReservation->id;
                            $reservations[$playerReservation->date][$playerReservation->time_slot_id][$playerReservation->court_id]['type'] = 'double';
                        }
                    }
                }
            }
        }

        foreach ($allDays as $day)
        {
            foreach ($timeSlots as $timeSlot)
            {
                foreach ($courts as $court)
                {
                    $court->hasType('simple') ? $courtSimpleAvailable++ : $courtDoubleAvailable++;

                    $indexDay = false;
                    $indexTimeSlot = false;
                    $indexCourt = false;
                    if (array_key_exists($day->format('Y-m-d'), $reservations))
                    {
                        $indexDay = true;
                        if (array_key_exists($timeSlot->id, $reservations[$day->format('Y-m-d')]))
                        {
                            $indexTimeSlot = true;
                            if (array_key_exists($court->id, $reservations[$day->format('Y-m-d')][$timeSlot->id]))
                            {
                                $indexCourt = true;
                            }
                        }
                    }

                    if (! $indexDay || ! $indexTimeSlot || ! $indexCourt)
                    {
                        $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['day'] = $day->format('Y-m-d');
                        $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['court_id'] = $court->id;
                        $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['timeSlot_id'] = $timeSlot->id;
                        $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] = null;
                        $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] = null;
                        $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['type'] = 'free';

                    }
                }
            }
        }

        if (count($adminReservations) > 0)
        {
            foreach ($adminReservations as $adminReservation)
            {
                foreach ($adminReservation->courts as $court)
                {
                    foreach ($adminReservation->timeSlots as $timeSlot)
                    {
                        $reservations[$adminReservation->start][$timeSlot->id][$court->id]['name'] = $adminReservation->title;
                        $reservations[$adminReservation->start][$timeSlot->id][$court->id]['content'] =
                            $adminReservation->comment;
                        $reservations[$adminReservation->start][$timeSlot->id][$court->id]['user_id'] =
                            $adminReservation->user_id;
                        $reservations[$adminReservation->start][$timeSlot->id][$court->id]['reservation_id'] =
                            $adminReservation->id;
                        $reservations[$adminReservation->start][$timeSlot->id][$court->id]['type'] =
                            'admin';
                    }
                }
            }
        }

        return view('reservation.index',
            compact('timeSlots', 'courts', 'allDays', 'reservations', 'courtSimpleAvailable', 'courtDoubleAvailable',
                'lastDayMonth'));
    }
}
