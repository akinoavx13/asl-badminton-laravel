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
use App\Tournament;
use App\Match;
use App\Serie;
use App\Score;
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

	public function getOpponent($userId, $userGender, $currentPeriodId, $type, $results, $isChampionship = true)
	{
      //$results = [];
		if ($isChampionship == true) 
		{
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
		} else 
		{
	  	// Tournament mode
			if ($type == 'simple') {
				$allMatches = Match::select('userOneT1.name as userOneT1Name', 'userOneT1.forname as userOneT1Forname', 'userOneT1.id as userOneT1Id', 'userOneT2.name as userOneT2Name', 'userOneT2.forname as userOneT2Forname', 'userOneT2.id as userOneT2Id')
				->join('series', 'matches.series_id', '=', 'series.id')
				->join('scores', 'scores.id', '=', 'matches.score_id')
				->join('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
				->join('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
				->join('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
				->join('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
				->join('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
				->join('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
				->where('series.tournament_id', $currentPeriodId)
				->where('userOneT1.id', '=', $userId)
				->where('series.category', 'like', 'S%')
				->where('scores.unplayed', '=', 1)
				->orWhere(function ($query) use ($currentPeriodId, $userId)
				{
					$query->where('series.tournament_id', $currentPeriodId)
					->where('userOneT2.id', '=', $userId)
					->where('series.category', 'like', 'S%')
					->where('scores.unplayed', '=', 1);
				})
				->get();

				if($allMatches == null) return $results;

				foreach ($allMatches as $index => $opponent) {
					if ($opponent->userOneT1Id == $userId) 
						$results[$opponent->userOneT2Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT2Forname, $opponent->userOneT2Name);
					if ($opponent->userOneT2Id == $userId) 
						$results[$opponent->userOneT1Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT1Forname, $opponent->userOneT1Name);
				}
			} else {
				if ($type == 'double') {
					$teamType = 'D';
				} else {
					$teamType = 'M';

				}
				
				$allMatches = Match::select('userOneT1.name as userOneT1Name', 'userOneT1.forname as userOneT1Forname', 'userOneT1.id as userOneT1Id', 'userTwoT1.name as userTwoT1Name', 'userTwoT1.forname as userTwoT1Forname', 'userTwoT1.id as userTwoT1Id', 'userOneT2.name as userOneT2Name', 'userOneT2.forname as userOneT2Forname', 'userOneT2.id as userOneT2Id', 'userTwoT2.name as userTwoT2Name', 'userTwoT2.forname as userTwoT2Forname', 'userTwoT2.id as userTwoT2Id')
				->join('series', 'matches.series_id', '=', 'series.id')
				->join('scores', 'scores.id', '=', 'matches.score_id')
				->join('teams as teamOne', 'teamOne.id', '=', 'matches.first_team_id')
				->join('teams as teamTwo', 'teamTwo.id', '=', 'matches.second_team_id')
				->join('players as playerOneT1', 'playerOneT1.id', '=', 'teamOne.player_one')
				->join('players as playerTwoT1', 'playerTwoT1.id', '=', 'teamOne.player_two')
				->join('players as playerOneT2', 'playerOneT2.id', '=', 'teamTwo.player_one')
				->join('players as playerTwoT2', 'playerTwoT2.id', '=', 'teamTwo.player_two')
				->join('users as userOneT1', 'userOneT1.id', '=', 'playerOneT1.user_id')
				->join('users as userTwoT1', 'userTwoT1.id', '=', 'playerTwoT1.user_id')
				->join('users as userOneT2', 'userOneT2.id', '=', 'playerOneT2.user_id')
				->join('users as userTwoT2', 'userTwoT2.id', '=', 'playerTwoT2.user_id')
				->where('series.tournament_id', $currentPeriodId)
				->where('userOneT1.id', '=', $userId)
				->where('scores.unplayed', '=', 1)
				->where('series.category', 'like', $teamType ."%")
				->orWhere(function ($query) use ($currentPeriodId, $userId, $teamType)
				{
					$query->where('series.tournament_id', $currentPeriodId)
					->where('userOneT2.id', '=', $userId)
					->where('scores.unplayed', '=', 1)
					->where('series.category', 'like', $teamType . '%');
				})
				->orWhere(function ($query) use ($currentPeriodId, $userId, $teamType)
				{
					$query->where('series.tournament_id', $currentPeriodId)
					->where('userTwoT1.id', '=', $userId)
					->where('scores.unplayed', '=', 1)
					->where('series.category', 'like', $teamType . '%');
				})
				->orWhere(function ($query) use ($currentPeriodId, $userId, $teamType)
				{
					$query->where('series.tournament_id', $currentPeriodId)
					->where('userTwoT2.id', '=', $userId)
					->where('scores.unplayed', '=', 1)
					->where('series.category', 'like', $teamType . '%');
				}) 
				->get();
				
				if($allMatches == null) return $results;
				
				foreach ($allMatches as $index => $opponent) {
					if ($opponent->userOneT1Id == $userId) {
						$results[$opponent->userTwoT1Id] =  Helpers::getInstance()->getTeamName($opponent->userTwoT1Forname, $opponent->userTwoT1Name);
						$results[$opponent->userOneT2Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT2Forname, $opponent->userOneT2Name);
						$results[$opponent->userTwoT2Id] =  Helpers::getInstance()->getTeamName($opponent->userTwoT2Forname, $opponent->userTwoT2Name);
					}
					if ($opponent->userTwoT1Id == $userId) {
						$results[$opponent->userOneT1Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT1Forname, $opponent->userOneT1Name);
						$results[$opponent->userOneT2Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT2Forname, $opponent->userOneT2Name);
						$results[$opponent->userTwoT2Id] =  Helpers::getInstance()->getTeamName($opponent->userTwoT2Forname, $opponent->userTwoT2Name);
					}
					if ($opponent->userOneT2Id == $userId) {
						$results[$opponent->userTwoT2Id] =  Helpers::getInstance()->getTeamName($opponent->userTwoT2Forname, $opponent->userTwoT2Name);
						$results[$opponent->userOneT1Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT1Forname, $opponent->userOneT1Name);
						$results[$opponent->userTwoT1Id] =  Helpers::getInstance()->getTeamName($opponent->userTwoT1Forname, $opponent->userTwoT1Name);
					}
					if ($opponent->userTwoT2Id == $userId) {
						$results[$opponent->userOneT2Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT2Forname, $opponent->userOneT2Name);
						$results[$opponent->userOneT1Id] =  Helpers::getInstance()->getTeamName($opponent->userOneT1Forname, $opponent->userOneT1Name);
						$results[$opponent->userTwoT1Id] =  Helpers::getInstance()->getTeamName($opponent->userTwoT1Forname, $opponent->userTwoT1Name);
					}
				}
				
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
    	
    	$currentPeriod = Period::getCurrentPeriod();
    	$currentTournament = Tournament::getCurrentTournament();
    	

    	if($currentPeriod == null && $currentTournament == null) return redirect()->back()->with('error', "Pas de championnat ni de tournoi en cours...");

      // on cherche les adversaires
    	$opponents = [];
    	$userId = $this->user->id;
    	$userGender = $this->user->gender;
    	if ($currentPeriod != null) 
    	{
    		$currentPeriodId = $currentPeriod->id; 
    		$isChampionship = true;
    	} else 
    	{ 
    		$currentPeriodId = $currentTournament->id;
    		$isChampionship = false;
    	}
    	

    	$opponents[$userId] =  Helpers::getInstance()->getTeamName($this->user->forname, $this->user->name);
    	if ($formule == 'simple' || $formule == 'all') $opponents = AvailabilityController::getOpponent($userId, $userGender, $currentPeriodId, 'simple', $opponents, $isChampionship);
    		if ($formule == 'double' || $formule == 'all') $opponents = AvailabilityController::getOpponent($userId, $userGender, $currentPeriodId, 'double', $opponents, $isChampionship);
    			if ($formule == 'mixte' || $formule == 'all') $opponents = AvailabilityController::getOpponent($userId, $userGender, $currentPeriodId, 'mixte', $opponents, $isChampionship);

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

    	return redirect()->back()->with('success', "Vos disponibilités sont mises à jour.");
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
