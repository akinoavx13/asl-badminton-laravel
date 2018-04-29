<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Utilities\Calendar;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\User;
use App\TimeSlot;
use App\Period;
use App\ChampionshipPool;
use App\ChampionshipRanking;
use App\Season;
use App\Team;
use App\Helpers;
use App\Availability;
use Jenssegers\Date\Date;

class AvailabilityController extends Controller
{

  public function __construct()
  {
      parent::__constructor();
  }

  public static function routes($router)
  {
      //pattern
      $router->pattern('user_id', '[0-9]+');
      $router->pattern('formule', '[0-9-a-z_]+');
      //user list

      $router->get('/index/{formule}', [
          'uses' => 'AvailabilityController@index',
          'as'   => 'availability.index',
      ]);

      $router->post('/index/{formule}', [
          'uses' => 'AvailabilityController@update',
          'as'   => 'availability.update',
      ]);
    }

    public function getOpponent($userId, $userGender, $currentPeriodId, $type, $results)
    {
      //$results = [];

      if ($type == 'simple') {
        $pool = ChampionshipPool::select('championship_pools.number', 'championship_pools.id as championshipPoolId')
            ->join('championship_rankings', 'championship_rankings.championship_pool_id', '=', 'championship_pools.id')
            ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
            ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
            ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
            ->where('teams.simple_' . $userGender, true)
            ->where('teams.enable', true)
            ->where('userOne.id', $userId)
            ->where('championship_pools.period_id', $currentPeriodId)
            ->first();
        if($pool == null) return $results;

        $poolId = $pool->championshipPoolId;
        $opponents = ChampionshipRanking::select('userOne.name as userName', 'userOne.forname as userForname', 'userOne.id as userId')
            ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
            ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
            ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
            ->where('championship_rankings.championship_pool_id', $poolId)
            ->get();

        foreach ($opponents as $index => $opponent) {
          $results[$opponent->userId] =  Helpers::getInstance()->getTeamName($opponent->userForname, $opponent->userName);
        }
      } else {
        if ($type == 'double') {
          $teamType = 'teams.double_' . $userGender;
        } else {
          $teamType = 'teams.mixte';
        }

        $pool = ChampionshipPool::select('championship_pools.number', 'championship_pools.id as championshipPoolId')
            ->join('championship_rankings', 'championship_rankings.championship_pool_id', '=', 'championship_pools.id')
            ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
            ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
            ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
            ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
            ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
            ->where($teamType, true)
            ->where('teams.enable', true)
            ->where('userOne.id', $userId)
            ->where('championship_pools.period_id', $currentPeriodId)
            ->orWhere(function ($query) use ($userId, $userGender, $currentPeriodId,$teamType)
            {
                $query->where($teamType, true)
                ->where('teams.enable', true)
                ->where('userTwo.id', $userId)
                ->where('championship_pools.period_id', $currentPeriodId);
            })
            ->first();

        if($pool == null) return $results;

        $poolId = $pool->championshipPoolId;
        $opponents = ChampionshipRanking::select('userOne.name as userOneName', 'userOne.forname as userOneForname', 'userOne.id as userOneId', 'userTwo.name as userTwoName', 'userTwo.forname as userTwoForname', 'userTwo.id as userTwoId')
            ->join('teams', 'teams.id', '=', 'championship_rankings.team_id')
            ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
            ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
            ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
            ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
            ->where('championship_rankings.championship_pool_id', $poolId)
            ->get();
        foreach ($opponents as $index => $opponent) {
          $results[$opponent->userOneId] =  Helpers::getInstance()->getTeamName($opponent->userOneForname, $opponent->userOneName);
          $results[$opponent->userTwoId] =  Helpers::getInstance()->getTeamName($opponent->userTwoForname, $opponent->userTwoName);
        }
      }

      return $results;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($formule)
    {
      $timeSlots = TimeSlot::orderBy('start')->get();
      $allDays = Calendar::getAllDaysMonth();

      $lastDayMonth = end($allDays);
      $firstDayMonth =$allDays[0];
      $today = Carbon::create($firstDayMonth->year, $firstDayMonth->month, $firstDayMonth->day)->format('Y-m-d');
      $reservations = [];
      $currentPeriod = Period::select(
        'id', 'start', 'end')
        ->where('periods.start', '<=', $today)
        ->where('periods.end', '>=', $today)
        ->first();

      if($currentPeriod == null) return redirect()->back()->with('error', "Pas de championnat en cours..");

      // on cherche les adversaires
      $opponents = [];
      $userId = $this->user->id;
      $userGender = $this->user->gender;
      $currentPeriodId = $currentPeriod->id;

      $opponents[$userId] =  Helpers::getInstance()->getTeamName($this->user->forname, $this->user->name);
      if ($formule == 'simple' || $formule == 'all') $opponents = AvailabilityController::getOpponent($userId, $userGender, $currentPeriodId, 'simple', $opponents);
      if ($formule == 'double' || $formule == 'all') $opponents = AvailabilityController::getOpponent($userId, $userGender, $currentPeriodId, 'double', $opponents);
      if ($formule == 'mixte' || $formule == 'all') $opponents = AvailabilityController::getOpponent($userId, $userGender, $currentPeriodId, 'mixte', $opponents);

      // on charge les dispos de tous les adversaires
      $opponentsID = [];
      foreach ($opponents as $opponentID => $opponent) {
        $opponentsID[$opponentID] = $opponentID;
      }
      $myAvailabilities = [];
      $existingAvailabilities = Availability::select('id', 'user_id', 'time_slot_id', 'date', 'available')
          //->where('user_id', $this->user->id)
          ->whereIn('user_id', $opponentsID)
          ->get();

      foreach ($existingAvailabilities as $key => $myAvailability) {
        $myAvailabilities[$myAvailability['date']->format('Y-m-d').'__'.$myAvailability['time_slot_id'].'__'.$myAvailability['user_id']] = $myAvailability['available'];
      }

      // on construit le tableau des dispos pour la vue
      foreach ($allDays as $index => $day)
      {
          foreach ($timeSlots as $timeSlot)
          {
              foreach ($opponents as $oppoenntID => $oppponent)
              {
                $reservations[$day->format('Y-m-d')][$timeSlot->id][$oppponent]['day'] = $day->format('Y-m-d');
                $reservations[$day->format('Y-m-d')][$timeSlot->id][$oppponent]['opponent'] = $oppponent;
                $reservations[$day->format('Y-m-d')][$timeSlot->id][$oppponent]['timeSlot_id'] = $timeSlot->id;
                $reservations[$day->format('Y-m-d')][$timeSlot->id][$oppponent]['user_id'] = null;
                $reservations[$day->format('Y-m-d')][$timeSlot->id][$oppponent]['reservation_id'] = null;
                //dd($myAvailabilities);
                if (array_key_exists($day->format('Y-m-d').'__'.$timeSlot->id.'__'.$oppoenntID, $myAvailabilities)) $type = $myAvailabilities[$day->format('Y-m-d').'__'.$timeSlot->id.'__'.$oppoenntID]; else $type = 0;
                $reservations[$day->format('Y-m-d')][$timeSlot->id][$oppponent]['type'] = $type;
              }
          }
      }

      return view('availability.index',
          compact('timeSlots', 'opponents', 'allDays', 'reservations', 'lastDayMonth', 'userId', 'formule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
      // on supprime toutes les dispos, puis on crée les nouvelles (on évite de chercher pour chaque dispo si elles existe déjà)
      $existingAvailabilities = Availability::select('id', 'user_id')
          ->where('user_id', $this->user->id)
          ->get();

      foreach ($existingAvailabilities as $key => $available) {
        $available->delete();
      }

      //on crée les nouvelles dispo
      foreach ($request->all() as $key => $value) {
        if($key != "_token") {
            $params = explode("__", $key);
            Availability::create([
                'user_id'   => $params[0],
                'date' => Date::createFromFormat('Y-m-d', $params[1]),
                'time_slot_id' => $params[2],
                'available' => ($value == 1?true:false),
            ]);
        }
      }

      return redirect()->back()->with('success', "vos disponibilités sont mises à jour.");
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
}
