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

    private function getSimples($id)
    {
      $user = User::findOrFail($id);
      $gender = $user->gender;

      $simples = Score::select(
          'userOneFirstTeam.name as userOneFirstTeamName', 'userOneFirstTeam.forname as userOneFirstTeamForname', 'userOneFirstTeam.id as userOneFirstTeamId',
          'userOneSecondTeam.name as userOneSecondTeamName', 'userOneSecondTeam.forname as userOneSecondTeamForname', 'userOneSecondTeam.id as userOneSecondTeamId',
          'scores.first_set_first_team', 'scores.first_set_second_team',
          'scores.second_set_first_team','scores.second_set_second_team',
          'scores.third_set_first_team', 'scores.third_set_second_team',
          'scores.my_wo as myWO', 'scores.his_wo as hisWO', 'scores.unplayed as unplayed', 'scores.id as scoreId', 'scores.updated_at as updated_at',
          'scores.first_team_win as first_team_win', 'scores.second_team_win as second_team_win')
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
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.simple_woman', true)
              ->where('userOneFirstTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.simple_man', true)
              ->where('userOneSecondTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.simple_woman', true)
              ->where('userOneSecondTeam.id', $id);
          })
          ->orderBy('scores.updated_at', 'desc')
          ->get();

      return $simples;
    }

    private function getOpponentName($score, $me)
    {
      if ($score->userOneFirstTeamId == $me)
          $name = Helpers::getInstance()->getTeamName($score->userOneSecondTeamForname, $score->userOneSecondTeamName);
      else
          $name = Helpers::getInstance()->getTeamName($score->userOneFirstTeamForname, $score->userOneFirstTeamName);

      return $name;
    }

    private function getOpponentID($score, $me)
    {
      if ($score->userOneFirstTeamId == $me)
          $id = $score->userOneSecondTeamId;
      else
          $id = $score->userOneFirstTeamId;

      return $id;
    }

    private function iWon($score, $me)
    {
      if (($score->userOneFirstTeamId == $me && $score->first_team_win) || ($score->userOneSecondTeamId == $me && $score->second_team_win)) {
        $won = true;
      } else {
        $won = false;
      }

      return $won;
    }

    private function diffPoint($score, $set, $me)
    {
      if ($score->userOneFirstTeamId == $me) {
        if ($set == 1)
          $diffPoint = $score->first_set_first_team - $score->first_set_second_team;
        if ($set == 2)
          $diffPoint = $score->second_set_first_team - $score->second_set_second_team;
        if ($set == 3)
          $diffPoint = $score->third_set_first_team - $score->third_set_second_team;
      } else {
        if ($set == 1)
          $diffPoint = $score->first_set_second_team - $score->first_set_first_team;
        if ($set == 2)
          $diffPoint = $score->second_set_second_team - $score->second_set_first_team;
        if ($set == 3)
          $diffPoint = $score->third_set_second_team - $score->third_set_first_team;
      }

      return $diffPoint;
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
      $gender = $user->gender;

      $simples = StatController::getSimples($id);

          $results = [];
          $opponentsWon = [];
          $opponentsLost = [];
          $opponentID = [];
          $setsDiffPoint = [];
          $setsOpponent = [];
          $setsBackgroundColor = [];
          $setsBordergroundColor = [];
          $type = 'simple';
          $nbSetPlayed = 0;
          $cumulStat = [];
          $cumulStat['nbMatch'] = 0;
          $cumulStat['nbMatchWon'] = 0;
          $cumulStat['nbMatchWonTwoSets'] = 0;
          $cumulStat['nbMatchWonThreeSets'] = 0;
          $cumulStat['nbMatchLost'] = 0;
          $cumulStat['nbMatchLostTwoSets'] = 0;
          $cumulStat['nbMatchLostThreeSets'] = 0;
          $cumulStat['diffSetMatchWon'] = 0;
          $cumulStat['diffSetMatchLost'] = 0;
          $cumulStat['diifSetTotal'] = 0;
          $cumulStat['nbSetWon'] = 0;
          $cumulStat['nbSetLost'] = 0;
          $cumulStat['diffPointSetWon'] = 0;
          $cumulStat['diffPointSetLost'] = 0;
          $cumulStat['diffPointTotal'] = 0;
          $cumulStat['percentWin'] = 0;
          $cumulStat['averageSetMatchWon'] = 0;
          $cumulStat['averageSetMatchLost'] = 0;
          $cumulStat['averagePointSetWon'] = 0;
          $cumulStat['averagePointSetLost'] = 0;
          $cumulStat['nbMyWO'] = 0;
          $cumulStat['nbHisWO'] = 0;
          $cumulStat['nbUnplayed'] = 0;

          $allBorderColor = ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"];
          $allBackgroundColor = ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"];
          $nbColors = 6;
          foreach ($simples as $index => $simple) {

            if (!$simple->unplayed && !$simple->hisWO && !$simple->myWO) {
              // construction de la liste des adversaires pour les matchs joués seulement
              $adversaireName = StatController::getOpponentName($simple, $id);
              $adversaireID = StatController::getOpponentID($simple, $id);

              if (StatController::iWon($simple, $id) == true) {
                if (array_key_exists($adversaireName, $opponentsWon)) $opponentsWon[$adversaireName]++; else $opponentsWon[$adversaireName] = 1;
              } else {
                if (array_key_exists($adversaireName, $opponentsLost)) $opponentsLost[$adversaireName]++; else $opponentsLost[$adversaireName] = 1;
              }
              $opponentID[$adversaireName] = $adversaireID;

              // construction du graphique de sets
              $borderColor = $allBorderColor[$index % 7];
              $backgroundColor = $allBackgroundColor[$index % 7];
              for ($set = 1;$set<=3;$set++) {
                if (StatController::diffPoint($simple, $set, $id) != 0) {
                  $setsOpponent[$nbSetPlayed] = $adversaireName;
                  $setsBorderColor[$nbSetPlayed] = $borderColor;
                  $setsBackgroundColor[$nbSetPlayed] = $backgroundColor;
                  $setsDiffPoint[$nbSetPlayed] = StatController::diffPoint($simple, $set, $id);
                  $nbSetPlayed++;
                }
              }
            }

            // construction du tableau de l'historique des matchs
            $results[$index]['date'] = $simple->updated_at;
            $results[$index]['firstTeamWin'] = $simple->first_team_win;
            $results[$index]['firstTeam'] = Helpers::getInstance()->getTeamName($simple->userOneFirstTeamForname, $simple->userOneFirstTeamName);
            $results[$index]['secondTeamWin'] = $simple->second_team_win;
            $results[$index]['secondTeam'] = Helpers::getInstance()->getTeamName($simple->userOneSecondTeamForname, $simple->userOneSecondTeamName);
            $results[$index]['first_set_first_team'] = $simple->first_set_first_team;
            $results[$index]['first_set_second_team'] = $simple->first_set_second_team;
            $results[$index]['second_set_first_team'] = $simple->second_set_first_team;
            $results[$index]['second_set_second_team'] = $simple->second_set_second_team;
            $results[$index]['third_set_first_team'] = $simple->third_set_first_team;
            $results[$index]['third_set_second_team'] = $simple->third_set_second_team;
            $results[$index]['my_wo'] = $simple->myWO;
            $results[$index]['his_wo'] = $simple->hisWO;
            $results[$index]['unplayed'] = $simple->unplayed;

            // calcul des statitisques
            if ($simple->unplayed) $cumulStat['nbUnplayed']++;
            if (($simple->myWO && $simple->userOneFirstTeamId == $id) || ($simple->hisWO && $simple->userOneSecondTeamId == $id)) $cumulStat['nbMyWO']++;
            if (($simple->hisWO && $simple->userOneFirstTeamId == $id) || ($simple->myWO && $simple->userOneSecondTeamId == $id)) $cumulStat['nbHisWO']++;
            if (!$simple->unplayed && !$simple->myWO && !$simple->hisWO) {
              $cumulStat['nbMatch']++;
              if (StatController::iWon($simple, $id) == true) {
                // match gagné
                $cumulStat['nbMatchWon']++;
                $indexMatchWonLost = 'diffSetMatchWon';
              } else {
                $cumulStat['nbMatchLost']++;
                $indexMatchWonLost = 'diffSetMatchLost';
              }
              for ($set = 1;$set<=3;$set++) {
                $setPoint = StatController::diffPoint($simple, $set, $id);
                if ($setPoint !=0) {
                  if ($setPoint > 0) {
                    $cumulStat['nbSetWon']++;
                    $cumulStat[$indexMatchWonLost]++;
                    $cumulStat['diffPointSetWon'] += $setPoint;
                  } else {
                    $cumulStat['nbSetLost']++;
                    $cumulStat[$indexMatchWonLost]--;
                    $cumulStat['diffPointSetLost'] -= -$setPoint;
                  }
                }
              }
            }
          }

          // on trie pour mettre en premier les adversaires les plus battus ou plus vainqueurs en tete
          arsort($opponentsLost);
          arsort($opponentsWon);

          $cumulStat['nbMatchTotal'] = $cumulStat['nbMatchWon'] + $cumulStat['nbMatchLost'];
          if ($cumulStat['nbMatchTotal']) $cumulStat['percentWin'] = (int)(100 * $cumulStat['nbMatchWon'] / $cumulStat['nbMatchTotal']);
          if($cumulStat['nbMatchWon']) $cumulStat['averageSetMatchWon'] = (int)(100 * $cumulStat['diffSetMatchWon'] / $cumulStat['nbMatchWon']) / 100;
          if($cumulStat['nbMatchLost']) $cumulStat['averageSetMatchLost'] = (int)(100 * $cumulStat['diffSetMatchLost'] / $cumulStat['nbMatchLost']) / 100;
          if($cumulStat['nbSetWon']) $cumulStat['averagePointSetWon'] = (int)(100 * $cumulStat['diffPointSetWon'] / $cumulStat['nbSetWon']) / 100;
          if($cumulStat['nbSetLost']) $cumulStat['averagePointSetLost'] = (int)(100 * $cumulStat['diffPointSetLost'] / $cumulStat['nbSetLost']) / 100;
          $cumulStat['nbMatchWonTwoSets'] = $cumulStat['diffSetMatchWon'] - $cumulStat['nbMatchWon'];
          $cumulStat['nbMatchWonThreeSets'] = 2 * $cumulStat['nbMatchWon'] - $cumulStat['diffSetMatchWon'];
          $cumulStat['nbMatchLostTwoSets'] = - $cumulStat['diffSetMatchLost'] - $cumulStat['nbMatchLost'];
          $cumulStat['nbMatchLostThreeSets'] =  2 * $cumulStat['nbMatchLost'] + $cumulStat['diffSetMatchLost'];
        return view('stat.show', compact('results', 'user','type', 'cumulStat', 'gender', 'opponentsWon', 'opponentsLost', 'opponentID', 'setsOpponent', 'setsDiffPoint', 'setsBackgroundColor', 'setsBorderColor'));
    }
}
