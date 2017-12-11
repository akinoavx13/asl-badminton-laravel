<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Score;
use App\Helpers;

class StatController extends Controller
{
  public static function routes($router)
  {
      //pattern
      $router->pattern('user_id', '[0-9]+');

      //user list
      $router->get('/{user_id}', [
          'uses'       => 'StatController@show',
          'as'         => 'stat.show',
      ]);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::findOrFail($id);

      $simples = Score::select(
          'userOneFirstTeam.name as userFirstTeamName', 'userOneFirstTeam.forname as userFirstTeamForname',
          'userOneFirstTeam.id as userFirstTeamId', 'userOneSecondTeam.name as userSecondTeamName',
          'userOneSecondTeam.forname as userSecondTeamForname', 'userOneSecondTeam.id as userSecondTeamId',
          'scores.first_set_first_team', 'scores.first_set_second_team', 'scores.second_set_first_team',
          'scores.second_set_second_team', 'scores.third_set_first_team', 'scores.third_set_second_team',
          'scores.my_wo as myWO', 'scores.his_wo as hisWO', 'scores.unplayed as unplayed', 'scores.id as scoreId',
          'scores.first_team_win as first_team_win', 'scores.second_team_win as second_team_win',
          'scores.updated_at as updated_at')
          ->join('teams as firstTeam', 'firstTeam.id', '=', 'scores.first_team_id')
          ->join('players as playerOneFirstTeam', 'playerOneFirstTeam.id', '=', 'firstTeam.player_one')
          ->join('users as userOneFirstTeam', 'userOneFirstTeam.id', '=', 'playerOneFirstTeam.user_id')
          //->join('players as playerTwoFirstTeam', 'playerTwoFirstTeam.id', '=', 'firstTeam.player_two')
          //->join('users as userTwoFirstTeam', 'userTwoFirstTeam.id', '=', 'playerTwoFirstTeam.user_id')
          ->join('teams as secondTeam', 'secondTeam.id', '=', 'scores.second_team_id')
          ->join('players as playerOneSecondTeam', 'playerOneSecondTeam.id', '=', 'secondTeam.player_one')
          ->join('users as userOneSecondTeam', 'userOneSecondTeam.id', '=', 'playerOneSecondTeam.user_id')
          //->join('players as playerTwoSecondTeam', 'playerTwoSecondTeam.id', '=', 'secondTeam.player_two')
          //->join('users as userTwoSecondTeam', 'userTwoSecondTeam.id', '=', 'playerTwoSecondTeam.user_id')
          //->join('championship_rankings as rankingFirstTeam', 'rankingFirstTeam.team_id', '=', 'firstTeam.id')
          //->join('championship_rankings as rankingSecondTeam', 'rankingSecondTeam.team_id', '=', 'secondTeam.id')
          //->where('rankingFirstTeam.championship_pool_id', $pool_id)
          //->where('rankingSecondTeam.championship_pool_id', $pool_id);
          //->where('scores.created_at', '>=', $currentPeriod->start->format('Y-m-d'))
          //->where('scores.created_at', '<=', $currentPeriod->end->format('Y-m-d'))
          //->where('firstTeam.simple_man', '=', true)
          ->where('firstTeam.simple_man', true)
          ->where('userOneFirstTeam.id', $id)
          ->orderBy('scores.updated_at', 'desc')
          ->get();

          //dd($simples);
          $results = [];
          $type = 'simple';
          $cumulStat = [];
          $cumulStat['nbMatch'] = 0;
          $cumulStat['nbWin'] = 0;
          $cumulStat['nbLost'] = 0;
          $cumulStat['percentWin'] = 0;
          $cumulStat['nbSet'] = 0;
          $cumulStat['nbPoint'] = 0;
          $cumulStat['nbMyWO'] = 0;
          $cumulStat['nbHisWO'] = 0;
          $cumulStat['nbUnplayed'] = 0;

          foreach ($simples as $index => $simple) {
            $results[$index]['date'] = $simple->updated_at;
            $results[$index]['firstTeamWin'] = $simple->first_team_win;
            $results[$index]['firstTeam'] = Helpers::getInstance()->getTeamName($simple->userFirstTeamForname, $simple->userFirstTeamName);
            $results[$index]['secondTeamWin'] = $simple->second_team_win;
            $results[$index]['secondTeam'] = Helpers::getInstance()->getTeamName($simple->userSecondTeamForname, $simple->userSecondTeamName);
            $results[$index]['first_set_first_team'] = $simple->first_set_first_team;
            $results[$index]['first_set_second_team'] = $simple->first_set_second_team;
            $results[$index]['second_set_first_team'] = $simple->second_set_first_team;
            $results[$index]['second_set_second_team'] = $simple->second_set_second_team;
            $results[$index]['third_set_first_team'] = $simple->third_set_first_team;
            $results[$index]['third_set_second_team'] = $simple->third_set_second_team;
            $results[$index]['my_wo'] = $simple->myWO;
            $results[$index]['his_wo'] = $simple->hisWO;
            $results[$index]['unplayed'] = $simple->unplayed;

            if ($simple->unplayed) {
                $cumulStat['nbUnplayed']++;
            } else if ($simple->myWO) {
              $cumulStat['nbMyWO']++;
            } else if($simple->hisWO) {
              $cumulStat['nbHisWO']++;
            } else {
              $cumulStat['nbMatch']++;
              if ($simple->first_team_win) {
                $cumulStat['nbWin']++;
              }
              else {
                $cumulStat['nbLost']++;
              }
              if ($simple->first_set_first_team > $simple->first_set_second_team) {
                  $cumulStat['nbSet']++;
              }
              else {
                $cumulStat['nbSet']--;
              }
              if ($simple->second_set_first_team > $simple->second_set_second_team) {
                  $cumulStat['nbSet']++;
              }
              else {
                $cumulStat['nbSet']--;
              }
              if ($simple->third_set_first_team !=0 && $simple->third_set_second_team !=0) {
                if ($simple->third_set_first_team > $simple->third_set_second_team) {
                    $cumulStat['nbSet']++;
                }
                else {
                  $cumulStat['nbSet']--;
                }
              }
              $cumulStat['nbPoint'] += $simple->first_set_first_team - $simple->first_set_second_team + $simple->second_set_first_team - $simple->second_set_second_team + $simple->third_set_first_team - $simple->third_set_second_team;
            }
          }
          $cumulStat['percentWin'] = (int)(100 * $cumulStat['nbWin'] / ($cumulStat['nbLost'] + $cumulStat['nbWin']));

        return view('stat.show', compact('results', 'user','type', 'cumulStat'));
    }


}
