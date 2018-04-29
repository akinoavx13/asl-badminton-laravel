<?php

namespace App\Http\Controllers;

use App\AdminsReservation;
use App\Court;
use App\Helpers;
use App\Http\Utilities\Calendar;
use App\PlayersReservation;
use App\Team;
use App\TimeSlot;
use App\Period;
use App\Score;
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

        $lastDayMonth = end($allDays);
        $firstDayMonth =$allDays[0];
        $today = Carbon::create($firstDayMonth->year, $firstDayMonth->month, $firstDayMonth->day)->format('Y-m-d');

        $playerReservations = PlayersReservation::where('date', '>=', Carbon::today())
            ->where('date', '<=', $lastDayMonth)
            ->orderBy('date')
            ->get();

        $adminReservationsNotRecurring = AdminsReservation::whereNull('end')
            ->where('start', '<=', $lastDayMonth)
            ->where('start', '>=', $today)
            ->orderBy('start')
            ->get();

        $adminReservationsRecurring = AdminsReservation::where('end', '>=', Carbon::today())
            ->where('start', '<=', $lastDayMonth)
            ->where('recurring', true)
            ->orderBy('start')
            ->get();

        $reservations = [];

        $courtSimpleAvailable = 0;
        $courtDoubleAvailable = 0;

        // recherche du nb de match non joues

        $currentPeriod = Period::select(
          'id', 'start', 'end')
          ->where('periods.start', '<=', $today)
          ->where('periods.end', '>=', $today)
          ->get();
          //dd($currentPeriod->count());
        
        $nbMixte = 0;
        $nbDoubleMen =0;
        $nbDoubleWomen = 0;
        $nbSimpleMen = 0;
        $nbSimpleWomen=0;
        
        if ($currentPeriod->count() != 0) 
        {
            //dd($currentPeriod[0]->start);
            $mixtes = Score::select(
                  'scores.id', 'scores.created_at', 'scores.unplayed', 'scores.first_team_id', 'teams.id', 'teams.mixte')
                  ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                  ->where('scores.created_at', '>=', $currentPeriod[0]->start->format('Y-m-d'))
                  ->where('scores.created_at', '<=', $currentPeriod[0]->end->format('Y-m-d'))
                  ->where('scores.unplayed', true)
                  ->where('teams.mixte', true)
                  ->get();
            $nbMixte = $mixtes->count();

            $doublesMen = Score::select(
                  'scores.id', 'scores.created_at', 'scores.unplayed', 'scores.first_team_id', 'teams.id', 'teams.double_man')
                  ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                  ->where('scores.created_at', '>=', $currentPeriod[0]->start->format('Y-m-d'))
                  ->where('scores.created_at', '<=', $currentPeriod[0]->end->format('Y-m-d'))
                  ->where('scores.unplayed', true)
                  ->where('teams.double_man', true)
                  ->get();
            $nbDoubleMen = $doublesMen->count();

            $doublesWomen = Score::select(
                  'scores.id', 'scores.created_at', 'scores.unplayed', 'scores.first_team_id', 'teams.id', 'teams.double_woman')
                  ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                  ->where('scores.created_at', '>=', $currentPeriod[0]->start->format('Y-m-d'))
                  ->where('scores.created_at', '<=', $currentPeriod[0]->end->format('Y-m-d'))
                  ->where('scores.unplayed', true)
                  ->where('teams.double_woman', true)
                  ->get();
            $nbDoubleWomen = $doublesWomen->count();

            $simpleMen = Score::select(
                  'scores.id', 'scores.created_at', 'scores.unplayed', 'scores.first_team_id', 'teams.id', 'teams.simple_man')
                  ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                  ->where('scores.created_at', '>=', $currentPeriod[0]->start->format('Y-m-d'))
                  ->where('scores.created_at', '<=', $currentPeriod[0]->end->format('Y-m-d'))
                  ->where('scores.unplayed', true)
                  ->where('teams.simple_man', true)
                  ->get();
            $nbSimpleMen = $simpleMen->count();

            $simpleWomen = Score::select(
                  'scores.id', 'scores.created_at', 'scores.unplayed', 'scores.first_team_id', 'teams.id', 'teams.simple_woman')
                  ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                  ->where('scores.created_at', '>=', $currentPeriod[0]->start->format('Y-m-d'))
                  ->where('scores.created_at', '<=', $currentPeriod[0]->end->format('Y-m-d'))
                  ->where('scores.unplayed', true)
                  ->where('teams.simple_woman', true)
                  ->get();
            $nbSimpleWomen = $simpleWomen->count();
        }

        $nbSimpleBooked = 0;
        $nbDoubleBooked = 0;

        if (count($playerReservations) > 0)
        {
            foreach ($playerReservations as $index => $playerReservation)
            {
                //si c'est du simple, je prend que le premier joueur des 2 équipes
                if ($courtType[$playerReservation->court_id] === 'simple')
                {
                    $nbSimpleBooked++;
                    $courtSimpleAvailable--;
                    $simpleTeams = Team::select('users.forname', 'users.name', 'users.id')
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
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['first_team'] = Helpers::getInstance()->getTeamName
                            ($firstTeam->forname, $firstTeam->name);
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['second_team'] = Helpers::getInstance()->getTeamName($secondTeam->forname,
                                $secondTeam->name);
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['user_id'] = $playerReservation->user_id;
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['reservation_id'] = $playerReservation->id;
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['type'] = 'simple';
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['owner'] = $this->user->id == $firstTeam->id || $this->user->id == $secondTeam->id;
                        }
                    }
                }
                //si c'est du double ou du mixte, je prends le premier et le deuxième joueur des 2 équipes
                else
                {
                    $nbDoubleBooked++;
                    $courtDoubleAvailable--;
                    $doubleOrMixteTeams = Team::select('userOne.forname AS fornameOne',
                        'userOne.name AS nameOne', 'userOne.id as userOneId',
                        'userTwo.forname AS fornameTwo',
                        'userTwo.name AS nameTwo', 'userTwo.id as userTwoId')
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
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id
                            ][$playerReservation->court_id]['first_team'] =
                                $firstTeam->fornameOne . ' ' . $firstTeam->nameOne . '<br> <span class="font-bold"> & </span> <br>' .
                                $firstTeam->fornameTwo . ' ' . $firstTeam->nameTwo;
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id][$playerReservation->court_id]['second_team'] = $secondTeam->fornameOne . ' ' . $secondTeam->nameOne . '<br> <span class="font-bold"> & </span> <br>' .
                                $secondTeam->fornameTwo . ' ' . $secondTeam->nameTwo;
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id
                            ][$playerReservation->court_id]['user_id'] = $playerReservation->user_id;
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id
                            ][$playerReservation->court_id]['reservation_id'] = $playerReservation->id;
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id
                            ][$playerReservation->court_id]['type'] = 'double';
                            $reservations[$playerReservation->date->format('Y-m-d')][$playerReservation->time_slot_id
                            ][$playerReservation->court_id]['owner'] = $this->user->id == $firstTeam->userOneId || $this->user->id == $firstTeam->userTwoId
                                || $this->user->id == $secondTeam->userOneId
                                || $this->user->id == $secondTeam->userTwoId
                            ;
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

        if (count($adminReservationsNotRecurring) > 0)
        {
            foreach ($adminReservationsNotRecurring as $adminReservationNotRecurring)
            {
                foreach ($adminReservationNotRecurring->courts as $court)
                {
                    foreach ($adminReservationNotRecurring->timeSlots as $timeSlot)
                    {
                        $court->hasType('simple') ? $courtSimpleAvailable-- : $courtDoubleAvailable--;
                        $reservations[$adminReservationNotRecurring->start->format('Y-m-d')][$timeSlot->id][$court->id]['name'] =
                            $adminReservationNotRecurring->title;
                        $reservations[$adminReservationNotRecurring->start->format('Y-m-d')][$timeSlot->id][$court->id]['content'] =
                            $adminReservationNotRecurring->comment;
                        $reservations[$adminReservationNotRecurring->start->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] =
                            $adminReservationNotRecurring->user_id;
                        $reservations[$adminReservationNotRecurring->start->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] =
                            $adminReservationNotRecurring->id;
                        $reservations[$adminReservationNotRecurring->start->format('Y-m-d')][$timeSlot->id][$court->id]['type'] =
                            'admin';
                    }
                }
            }
        }

        if (count($adminReservationsRecurring) > 0)
        {
            foreach ($adminReservationsRecurring as $adminReservationRecurring)
            {
                foreach ($adminReservationRecurring->courts as $court)
                {
                    foreach ($adminReservationRecurring->timeSlots as $timeSlot)
                    {
                        //$day = Carbon::create($adminReservationRecurring->start->year,
                        //$adminReservationRecurring->start->month, $adminReservationRecurring->start->day);
                        $day = Carbon::create($firstDayMonth->year, $firstDayMonth->month, $firstDayMonth->day);

                        //while ($day <= $adminReservationRecurring->end)
                        while ($day <= $lastDayMonth)
                        {
                            if($adminReservationRecurring->monday == true && $day->isMonday())
                            {
                                $court->hasType('simple') ? $courtSimpleAvailable-- : $courtDoubleAvailable--;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['name'] =
                                    $adminReservationRecurring->title;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['content'] =
                                    $adminReservationRecurring->comment;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] =
                                    $adminReservationRecurring->user_id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] =
                                    $adminReservationRecurring->id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['type'] =
                                    'admin';
                            }
                            if($adminReservationRecurring->tuesday == true && $day->isTuesday())
                            {
                                $court->hasType('simple') ? $courtSimpleAvailable-- : $courtDoubleAvailable--;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['name'] =
                                    $adminReservationRecurring->title;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['content'] =
                                    $adminReservationRecurring->comment;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] =
                                    $adminReservationRecurring->user_id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] =
                                    $adminReservationRecurring->id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['type'] =
                                    'admin';
                            }
                            if($adminReservationRecurring->wednesday == true && $day->isWednesday())
                            {
                                $court->hasType('simple') ? $courtSimpleAvailable-- : $courtDoubleAvailable--;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['name'] =
                                    $adminReservationRecurring->title;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['content'] =
                                    $adminReservationRecurring->comment;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] =
                                    $adminReservationRecurring->user_id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] =
                                    $adminReservationRecurring->id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['type'] =
                                    'admin';
                            }
                            if($adminReservationRecurring->thursday == true && $day->isThursday())
                            {
                                $court->hasType('simple') ? $courtSimpleAvailable-- : $courtDoubleAvailable--;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['name'] =
                                    $adminReservationRecurring->title;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['content'] =
                                    $adminReservationRecurring->comment;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] =
                                    $adminReservationRecurring->user_id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] =
                                    $adminReservationRecurring->id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['type'] =
                                    'admin';
                            }
                            if($adminReservationRecurring->friday == true && $day->isFriday())
                            {
                                $court->hasType('simple') ? $courtSimpleAvailable-- : $courtDoubleAvailable--;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['name'] =
                                    $adminReservationRecurring->title;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['content'] =
                                    $adminReservationRecurring->comment;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['user_id'] =
                                    $adminReservationRecurring->user_id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['reservation_id'] =
                                    $adminReservationRecurring->id;
                                $reservations[$day->format('Y-m-d')][$timeSlot->id][$court->id]['type'] =
                                    'admin';
                            }

                            $day->addDay();
                        }
                    }
                }
            }
        }


        return view('reservation.index',
            compact('timeSlots', 'courts', 'allDays', 'reservations', 'courtSimpleAvailable', 'courtDoubleAvailable',
                'lastDayMonth', 'nbMixte', 'nbDoubleMen', 'nbDoubleWomen', 'nbSimpleMen', 'nbSimpleWomen', 'nbSimpleBooked', 'nbDoubleBooked'));
    }
}
