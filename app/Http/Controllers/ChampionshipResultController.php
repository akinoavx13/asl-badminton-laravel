<?php

namespace App\Http\Controllers;

use App\ChampionshipPool;
use App\Helpers;
use App\Http\Requests;
use App\Period;
use App\Score;
use App\Season;
use Carbon\Carbon;

class ChampionshipResultController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //patterns
        $router->pattern('pool_id', '[0-9]+');
        $router->pattern('period_id', '[0-9]+');
        $router->pattern('anchor', '[0-9-a-z_]+');

        //admin reservation create day
        $router->get('show/{pool_id}/{period_id}/{anchor}', [
            'uses' => 'ChampionshipResultController@show',
            'as'   => 'championshipResult.show',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $pool_id
     * @return \Illuminate\Http\Response
     */
    public function show($pool_id, $period_id, $anchor)
    {
        $pool = ChampionshipPool::findOrFail($pool_id);

        $period = Period::findOrFail($period_id);

        $type = $pool->type;

        if ($pool->type == 'simple' || $pool->type == 'simple_man' || $pool->type == 'simple_woman')
        {
            $type = 'simple';
        }
        elseif ($pool->type == 'double' || $pool->type == 'double_man' || $pool->type == 'double_woman')
        {
            $type = 'double';
        }

        $results = $this->getResults($pool_id, $type, $period_id);

        $today = Carbon::today()->format('Y-m-d');

        return view('championshipResult.show', compact('pool', 'results', 'type', 'anchor', 'period', 'today'));
    }

    private function getResults($pool_id, $type, $period_id)
    {

        $scores = [];

        $activeSeason = Season::active()->first();

        if ($activeSeason != null)
        {
            $currentPeriod = Period::findOrFail($period_id);

            if ($currentPeriod != null)
            {
                if ($type == 'simple')
                {
                    $scores = Score::select(
                        'userFirstTeam.name as userFirstTeamName', 'userFirstTeam.forname as userFirstTeamForname',
                        'userFirstTeam.id as userFirstTeamId', 'userSecondTeam.name as userSecondTeamName',
                        'userSecondTeam.forname as userSecondTeamForname', 'userSecondTeam.id as userSecondTeamId',
                        'scores.first_set_first_team', 'scores.first_set_second_team', 'scores.second_set_first_team',
                        'scores.second_set_second_team', 'scores.third_set_first_team', 'scores.third_set_second_team',
                        'scores.my_wo', 'scores.his_wo', 'scores.unplayed', 'scores.id as scoreId',
                        'scores.first_team_win', 'scores.second_team_win')
                        ->allScoresSimpleInSelectedPool($pool_id)
                        ->where('scores.created_at', '>=', $currentPeriod->start->format('Y-m-d'))
                        ->where('scores.created_at', '<=', $currentPeriod->end->format('Y-m-d'))
                        ->get();
                }
                else
                {
                    $scores = Score::select(
                        'userOneFirstTeam.name as userOneFirstTeamName',
                        'userOneFirstTeam.forname as userOneFirstTeamForname',
                        'userOneFirstTeam.id as userOneFirstTeamId', 'userTwoFirstTeam.name as userTwoFirstTeamName',
                        'userTwoFirstTeam.forname as userTwoFirstTeamForname',
                        'userTwoFirstTeam.id as userTwoFirstTeamId',
                        'userOneSecondTeam.name as userOneSecondTeamName',
                        'userOneSecondTeam.forname as userOneSecondTeamForname',
                        'userOneSecondTeam.id as userOneSecondTeamId',
                        'userTwoSecondTeam.name as userTwoSecondTeamName',
                        'userTwoSecondTeam.forname as userTwoSecondTeamForname',
                        'userTwoSecondTeam.id as userTwoSecondTeamId',
                        'scores.first_set_first_team', 'scores.first_set_second_team', 'scores.second_set_first_team',
                        'scores.second_set_second_team', 'scores.third_set_first_team', 'scores.third_set_second_team',
                        'scores.my_wo', 'scores.his_wo', 'scores.unplayed', 'scores.id as scoreId',
                        'scores.first_team_win', 'scores.second_team_win')
                        ->allScoresDoubleOrMixteInSelectedPool($pool_id)
                        ->where('scores.created_at', '>=', $currentPeriod->start->format('Y-m-d'))
                        ->where('scores.created_at', '<=', $currentPeriod->end->format('Y-m-d'))
                        ->get();
                }
            }
        }

        $results = [];

        foreach ($scores as $index => $score)
        {
            if ($type == 'simple')
            {
                $results[$index]['firstTeam'] = Helpers::getInstance()->getTeamName($score->userFirstTeamForname,
                    $score->userFirstTeamName);
                $results[$index]['secondTeam'] = Helpers::getInstance()->getTeamName($score->userSecondTeamForname,
                    $score->userSecondTeamName);
                $results[$index]['owner'] = $this->user->id == $score->userFirstTeamId || $this->user->id ==
                    $score->userSecondTeamId;
            }
            else
            {
                $results[$index]['firstTeam'] = Helpers::getInstance()->getTeamName($score->userOneFirstTeamForname,
                    $score->userOneFirstTeamName, $score->userTwoFirstTeamForname, $score->userTwoFirstTeamName);

                $results[$index]['secondTeam'] = Helpers::getInstance()->getTeamName($score->userOneSecondTeamForname,
                    $score->userOneSecondTeamName, $score->userTwoSecondTeamForname, $score->userTwoSecondTeamName);

                $results[$index]['owner'] = $this->user->id == $score->userOneFirstTeamId || $this->user->id ==
                    $score->userTwoFirstTeamId || $this->user->id == $score->userOneSecondTeamId || $this->user->id ==
                    $score->userTwoSecondTeamId;
            }

            $results[$index]['first_set_first_team'] = $score->first_set_first_team;
            $results[$index]['first_set_second_team'] = $score->first_set_second_team;
            $results[$index]['second_set_first_team'] = $score->second_set_first_team;
            $results[$index]['second_set_second_team'] = $score->second_set_second_team;
            $results[$index]['third_set_first_team'] = $score->third_set_first_team;
            $results[$index]['third_set_second_team'] = $score->third_set_second_team;
            $results[$index]['my_wo'] = $score->my_wo;
            $results[$index]['his_wo'] = $score->his_wo;
            $results[$index]['unplayed'] = $score->unplayed;
            $results[$index]['scoreId'] = $score->scoreId;

            $results[$index]['firstTeamWin'] = $score->first_team_win;
            $results[$index]['secondTeamWin'] = $score->second_team_win;
        }

        return $results;
    }
}
