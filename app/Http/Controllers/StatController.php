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

      $matchs = Score::select(
          'userOneFirstTeam.name as userOneFirstTeamName', 'userOneFirstTeam.forname as userOneFirstTeamForname',
          'userOneFirstTeam.id as userOneFirstTeamId',
          'userOneSecondTeam.name as userOneSecondTeamName', 'userOneSecondTeam.forname as userOneSecondTeamForname',
          'userOneSecondTeam.id as userOneSecondTeamId',
          'scores.first_set_first_team', 'scores.first_set_second_team',
          'scores.second_set_first_team','scores.second_set_second_team',
          'scores.third_set_first_team', 'scores.third_set_second_team',
          'scores.my_wo as myWO', 'scores.his_wo as hisWO', 'scores.unplayed as unplayed', 'scores.id as scoreId', 'scores.updated_at as updated_at',
          'scores.first_team_win as first_team_win', 'scores.second_team_win as second_team_win')
          ->join('teams as firstTeam', 'firstTeam.id', '=', 'scores.first_team_id')
          ->join('players as playerOneFirstTeam', 'playerOneFirstTeam.id', '=', 'firstTeam.player_one')
          ->join('users as userOneFirstTeam', 'userOneFirstTeam.id', '=', 'playerOneFirstTeam.user_id')
          ->join('teams as secondTeam', 'secondTeam.id', '=', 'scores.second_team_id')
          ->join('players as playerOneSecondTeam', 'playerOneSecondTeam.id', '=', 'secondTeam.player_one')
          ->join('users as userOneSecondTeam', 'userOneSecondTeam.id', '=', 'playerOneSecondTeam.user_id')
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

      return $matchs;
    }

    private function getDoubles($id)
    {
      $user = User::findOrFail($id);
      $gender = $user->gender;

      $matchs = Score::select(
          'userOneFirstTeam.name as userOneFirstTeamName', 'userOneFirstTeam.forname as userOneFirstTeamForname',
          'userTwoFirstTeam.name as userTwoFirstTeamName', 'userTwoFirstTeam.forname as userTwoFirstTeamForname',
          'userOneFirstTeam.id as userOneFirstTeamId', 'userTwoFirstTeam.id as userTwoFirstTeamId',
          'userOneSecondTeam.name as userOneSecondTeamName', 'userOneSecondTeam.forname as userOneSecondTeamForname',
          'userTwoSecondTeam.name as userTwoSecondTeamName', 'userTwoSecondTeam.forname as userTwoSecondTeamForname',
          'userOneSecondTeam.id as userOneSecondTeamId', 'userTwoSecondTeam.id as userTwoSecondTeamId',
          'scores.first_set_first_team', 'scores.first_set_second_team',
          'scores.second_set_first_team','scores.second_set_second_team',
          'scores.third_set_first_team', 'scores.third_set_second_team',
          'scores.my_wo as myWO', 'scores.his_wo as hisWO', 'scores.unplayed as unplayed', 'scores.id as scoreId', 'scores.updated_at as updated_at',
          'scores.first_team_win as first_team_win', 'scores.second_team_win as second_team_win')
          ->join('teams as firstTeam', 'firstTeam.id', '=', 'scores.first_team_id')
          ->join('players as playerOneFirstTeam', 'playerOneFirstTeam.id', '=', 'firstTeam.player_one')
          ->join('users as userOneFirstTeam', 'userOneFirstTeam.id', '=', 'playerOneFirstTeam.user_id')
          ->join('players as playerTwoFirstTeam', 'playerTwoFirstTeam.id', '=', 'firstTeam.player_two')
          ->join('users as userTwoFirstTeam', 'userTwoFirstTeam.id', '=', 'playerTwoFirstTeam.user_id')
          ->join('teams as secondTeam', 'secondTeam.id', '=', 'scores.second_team_id')
          ->join('players as playerOneSecondTeam', 'playerOneSecondTeam.id', '=', 'secondTeam.player_one')
          ->join('users as userOneSecondTeam', 'userOneSecondTeam.id', '=', 'playerOneSecondTeam.user_id')
          ->join('players as playerTwoSecondTeam', 'playerTwoSecondTeam.id', '=', 'secondTeam.player_two')
          ->join('users as userTwoSecondTeam', 'userTwoSecondTeam.id', '=', 'playerTwoSecondTeam.user_id')
          ->where('firstTeam.double_man', true)
          ->where('userOneFirstTeam.id', $id)
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_man', true)
              ->where('userTwoFirstTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_man', true)
              ->where('userOneSecondTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_man', true)
              ->where('userTwoSecondTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_woman', true)
              ->where('userOneFirstTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_woman', true)
              ->where('userTwoFirstTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_woman', true)
              ->where('userOneSecondTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.double_woman', true)
              ->where('userTwoSecondTeam.id', $id);
          })
          ->orderBy('scores.updated_at', 'desc')
          ->get();

      return $matchs;
    }

    private function getMixtes($id)
    {
      $user = User::findOrFail($id);
      $gender = $user->gender;

      $matchs = Score::select(
          'userOneFirstTeam.name as userOneFirstTeamName', 'userOneFirstTeam.forname as userOneFirstTeamForname',
          'userTwoFirstTeam.name as userTwoFirstTeamName', 'userTwoFirstTeam.forname as userTwoFirstTeamForname',
          'userOneFirstTeam.id as userOneFirstTeamId', 'userTwoFirstTeam.id as userTwoFirstTeamId',
          'userOneSecondTeam.name as userOneSecondTeamName', 'userOneSecondTeam.forname as userOneSecondTeamForname',
          'userTwoSecondTeam.name as userTwoSecondTeamName', 'userTwoSecondTeam.forname as userTwoSecondTeamForname',
          'userOneSecondTeam.id as userOneSecondTeamId', 'userTwoSecondTeam.id as userTwoSecondTeamId',
          'scores.first_set_first_team', 'scores.first_set_second_team',
          'scores.second_set_first_team','scores.second_set_second_team',
          'scores.third_set_first_team', 'scores.third_set_second_team',
          'scores.my_wo as myWO', 'scores.his_wo as hisWO', 'scores.unplayed as unplayed', 'scores.id as scoreId', 'scores.updated_at as updated_at',
          'scores.first_team_win as first_team_win', 'scores.second_team_win as second_team_win')
          ->join('teams as firstTeam', 'firstTeam.id', '=', 'scores.first_team_id')
          ->join('players as playerOneFirstTeam', 'playerOneFirstTeam.id', '=', 'firstTeam.player_one')
          ->join('users as userOneFirstTeam', 'userOneFirstTeam.id', '=', 'playerOneFirstTeam.user_id')
          ->join('players as playerTwoFirstTeam', 'playerTwoFirstTeam.id', '=', 'firstTeam.player_two')
          ->join('users as userTwoFirstTeam', 'userTwoFirstTeam.id', '=', 'playerTwoFirstTeam.user_id')
          ->join('teams as secondTeam', 'secondTeam.id', '=', 'scores.second_team_id')
          ->join('players as playerOneSecondTeam', 'playerOneSecondTeam.id', '=', 'secondTeam.player_one')
          ->join('users as userOneSecondTeam', 'userOneSecondTeam.id', '=', 'playerOneSecondTeam.user_id')
          ->join('players as playerTwoSecondTeam', 'playerTwoSecondTeam.id', '=', 'secondTeam.player_two')
          ->join('users as userTwoSecondTeam', 'userTwoSecondTeam.id', '=', 'playerTwoSecondTeam.user_id')
          ->where('firstTeam.mixte', true)
          ->where('userOneFirstTeam.id', $id)
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.mixte', true)
              ->where('userTwoFirstTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.mixte', true)
              ->where('userOneSecondTeam.id', $id);
          })
          ->orWhere(function ($query) use ($id)
          {
              $query->where('firstTeam.mixte', true)
              ->where('userTwoSecondTeam.id', $id);
          })
          ->orderBy('scores.updated_at', 'desc')
          ->get();

      return $matchs;
    }

    private function getOpponentName($score, $me, $type)
    {
      if ($type == 'simple') {
        if ($score->userOneFirstTeamId == $me)
            $name = Helpers::getInstance()->getTeamName($score->userOneSecondTeamForname, $score->userOneSecondTeamName);
        else
            $name = Helpers::getInstance()->getTeamName($score->userOneFirstTeamForname, $score->userOneFirstTeamName);
      } else {
        // double ou mixte
        if ($score->userOneFirstTeamId == $me || $score->userTwoFirstTeamId == $me)
            $name = Helpers::getInstance()->getTeamName($score->userOneSecondTeamForname, $score->userOneSecondTeamName, $score->userTwoSecondTeamForname, $score->userTwoSecondTeamName);
        else
            $name = Helpers::getInstance()->getTeamName($score->userOneFirstTeamForname, $score->userOneFirstTeamName, $score->userTwoFirstTeamForname, $score->userTwoFirstTeamName);
      }

      //$name = preg_replace( '#(éèëê)+#', 'e', $name );
      $name = preg_replace( '#(à)+#', 'a', $name );
      $name = preg_replace( '#(ä)+#', 'a', $name );
      $name = preg_replace( '#(â)+#', 'a', $name );

      $name = preg_replace( '#(é)+#', 'e', $name );
      $name = preg_replace( '#(è)+#', 'e', $name );
      $name = preg_replace( '#(ë)+#', 'e', $name );
      $name = preg_replace( '#(ê)+#', 'e', $name );

      $name = preg_replace( '#(ï)+#', 'i', $name );
      $name = preg_replace( '#(î)+#', 'i', $name );

      $name = preg_replace( '#(ö)+#', 'o', $name );
      $name = preg_replace( '#(ô)+#', 'o', $name );

      $name = preg_replace( '#(ù)+#', 'u', $name );
      $name = preg_replace( '#(ü)+#', 'u', $name );
      $name = preg_replace( '#(û)+#', 'u', $name );

      $name = preg_replace( '#(ç)+#', 'c', $name );

      return $name;
    }

    private function getOpponentID($score, $me, $type)
    {
      if ($type == 'simple') {
        if ($score->userOneFirstTeamId == $me)
            $id = $score->userOneSecondTeamId;
        else
            $id = $score->userOneFirstTeamId;
      } else {
        // double ou mixte
        if ($score->userOneFirstTeamId == $me || $score->userTwoFirstTeamId == $me)
            $id = $score->userOneSecondTeamId;
        else
            $id = $score->userOneFirstTeamId;
      }

      return $id;
    }

    private function iWon($score, $me, $type)
    {
      if ($type == 'simple') {
        if (($score->userOneFirstTeamId == $me && $score->first_team_win) || ($score->userOneSecondTeamId == $me && $score->second_team_win)) {
          $won = true;
        } else {
          $won = false;
        }
      } else {
        // double ou mixte

        //if ($score->scoreId == 1253) dd($me, $score);

        if ((($score->userOneFirstTeamId == $me || $score->userTwoFirstTeamId == $me) && $score->first_team_win) || (($score->userOneSecondTeamId == $me || $score->userTwoSecondTeamId == $me) && $score->second_team_win)) {
          $won = true;
        } else {
          $won = false;
        }
      }

      return $won;
    }

    private function diffPoint($score, $set, $me, $type)
    {
      if ($type == 'simple') {
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
      } else {
        // double ou mixte
        if ($score->userOneFirstTeamId == $me || $score->userTwoFirstTeamId == $me) {
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

      $allBorderColor = ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"];
      $allBackgroundColor = ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"];
      $nbColors = 6;

      foreach (['simple', 'double', 'mixte'] as $key => $type) {
        $longuestWonSerie[$type] = 0;
        $longuestLostSerie[$type] = 0;
        $currentSerie = 0;
        $previousMatch = "";
        $opponentsWon[$type] = [];
        $opponentsLost[$type] = [];
        $opponentID[$type] = [];
        $nbSetPlayed = 0;
        $setsDiffPoint[$type] = [];
        $setsOpponent[$type] = [];
        $setsBackgroundColor[$type] = [];
        $setsBorderColor[$type] = [];
        $results[$type] = [];
        $cumulStat[$type]['nbUnplayed'] = 0;
        $cumulStat[$type]['nbMyWO'] = 0;
        $cumulStat[$type]['nbHisWO'] = 0;
        $cumulStat[$type]['nbMatch'] = 0;
        $cumulStat[$type]['nbMatchWon'] = 0;
        $cumulStat[$type]['nbMatchWonTwoSets'] = 0;
        $cumulStat[$type]['nbMatchWonThreeSets'] = 0;
        $cumulStat[$type]['nbMatchLost'] = 0;
        $cumulStat[$type]['nbMatchLostTwoSets'] = 0;
        $cumulStat[$type]['nbMatchLostThreeSets'] = 0;
        $cumulStat[$type]['percentWin'] = 0;
        $cumulStat[$type]['diffSetMatchWon'] = 0;
        $cumulStat[$type]['diffSetMatchLost'] = 0;
        $cumulStat[$type]['nbSetWon'] = 0;
        $cumulStat[$type]['nbSetLost'] = 0;

        if ($type == 'simple') $matchs = StatController::getSimples($id);
        if ($type == 'double') $matchs = StatController::getDoubles($id);
        if ($type == 'mixte') $matchs = StatController::getMixtes($id);

        foreach ($matchs as $index => $match) {

          if (!$match->unplayed && !$match->hisWO && !$match->myWO) {
            // construction de la liste des adversaires pour les matchs joués seulement
            $adversaireName = StatController::getOpponentName($match, $id, $type);
            $adversaireID = StatController::getOpponentID($match, $id, $type);


            //if ($type == 'mixte' && $match->second_team_win && $match->userOneSecondTeamId == 33) dd($match);


            if (StatController::iWon($match, $id, $type) == true) {
              if($previousMatch == "") $previousMatch = "Won";
              if ($previousMatch == "Won") $currentSerie++; else $currentSerie = 1;
              $longuestWonSerie[$type] = Max($longuestWonSerie[$type], $currentSerie);
              $previousMatch = "Won";
              if (array_key_exists($adversaireName, $opponentsWon[$type])) $opponentsWon[$type][$adversaireName]++; else $opponentsWon[$type][$adversaireName] = 1;

            } else {
              if($previousMatch == "") $previousMatch = "Lost";
              if ($previousMatch == "Lost") $currentSerie++; else $currentSerie = 1;
              $longuestLostSerie[$type] = Max($longuestLostSerie[$type], $currentSerie);
              $previousMatch = "Lost";
              if (array_key_exists($adversaireName, $opponentsLost[$type])) $opponentsLost[$type][$adversaireName]++; else $opponentsLost[$type][$adversaireName] = 1;
            }
            $opponentID[$type][$adversaireName] = $adversaireID;

            // construction du graphique de sets
            $borderColor = $allBorderColor[$index % ($nbColors + 1)];
            $backgroundColor = $allBackgroundColor[$index % ($nbColors + 1)];
            for ($set = 1;$set<=3;$set++) {
              if (StatController::diffPoint($match, $set, $id, $type) != 0) {
                $setsOpponent[$type][$nbSetPlayed] = $adversaireName;
                $setsBorderColor[$type][$nbSetPlayed] = $borderColor;
                $setsBackgroundColor[$type][$nbSetPlayed] = $backgroundColor;
                $setsDiffPoint[$type][$nbSetPlayed] = StatController::diffPoint($match, $set, $id, $type);
                $nbSetPlayed++;
              }
            }
          }

          // construction du tableau de l'historique des matchs
          $results[$type][$index]['date'] = $match->updated_at;
          $results[$type][$index]['firstTeamWin'] = $match->first_team_win;
          if ($type == 'simple')
            $results[$type][$index]['firstTeam'] = Helpers::getInstance()->getTeamName($match->userOneFirstTeamForname, $match->userOneFirstTeamName);
          else
            $results[$type][$index]['firstTeam'] = Helpers::getInstance()->getTeamName($match->userOneFirstTeamForname, $match->userOneFirstTeamName, $match->userTwoFirstTeamForname, $match->userTwoFirstTeamName);
          $results[$type][$index]['secondTeamWin'] = $match->second_team_win;
          if ($type == 'simple')
            $results[$type][$index]['secondTeam'] = Helpers::getInstance()->getTeamName($match->userOneSecondTeamForname, $match->userOneSecondTeamName);
          else
            $results[$type][$index]['secondTeam'] = Helpers::getInstance()->getTeamName($match->userOneSecondTeamForname, $match->userOneSecondTeamName, $match->userTwoSecondTeamForname, $match->userTwoSecondTeamName);
          $results[$type][$index]['first_set_first_team'] = $match->first_set_first_team;
          $results[$type][$index]['first_set_second_team'] = $match->first_set_second_team;
          $results[$type][$index]['second_set_first_team'] = $match->second_set_first_team;
          $results[$type][$index]['second_set_second_team'] = $match->second_set_second_team;
          $results[$type][$index]['third_set_first_team'] = $match->third_set_first_team;
          $results[$type][$index]['third_set_second_team'] = $match->third_set_second_team;
          $results[$type][$index]['my_wo'] = $match->myWO;
          $results[$type][$index]['his_wo'] = $match->hisWO;
          $results[$type][$index]['unplayed'] = $match->unplayed;

          // calcul des statitisques
          if ($match->unplayed) $cumulStat[$type]['nbUnplayed']++;
          if (($match->myWO && ($match->userOneFirstTeamId == $id || $match->userTwoFirstTeamId == $id)) || ($match->hisWO && ($match->userOneSecondTeamId == $id || $match->userTwoSecondTeamId == $id))) $cumulStat[$type]['nbMyWO']++;
          if (($match->hisWO && ($match->userOneFirstTeamId == $id || $match->userTwoFirstTeamId == $id)) || ($match->myWO && ($match->userOneSecondTeamId == $id || $match->userTwoSecondTeamId == $id))) $cumulStat[$type]['nbHisWO']++;

          if (!$match->unplayed && !$match->myWO && !$match->hisWO) {
            $cumulStat[$type]['nbMatch']++;
            if (StatController::iWon($match, $id, $type) == true) {
              // match gagné
              $cumulStat[$type]['nbMatchWon']++;
              $indexMatchWonLost = 'diffSetMatchWon';
            } else {
              $cumulStat[$type]['nbMatchLost']++;
              $indexMatchWonLost = 'diffSetMatchLost';
            }
            for ($set = 1;$set<=3;$set++) {
              $setPoint = StatController::diffPoint($match, $set, $id, $type);
              if ($setPoint !=0) {
                if ($setPoint > 0) {
                  $cumulStat[$type]['nbSetWon']++;
                  $cumulStat[$type][$indexMatchWonLost]++;
                } else {
                  $cumulStat[$type]['nbSetLost']++;
                  $cumulStat[$type][$indexMatchWonLost]--;
                }
              }
            }
          }
        }

        // on trie pour mettre en premier les adversaires les plus battus ou plus vainqueurs en tete
        arsort($opponentsLost[$type]);
        arsort($opponentsWon[$type]);

        // on renverse le graphique des sets pour avoir l'axe X dans le bons sens
        $setsOpponent[$type] = array_reverse($setsOpponent[$type]);
        $setsDiffPoint[$type] = array_reverse($setsDiffPoint[$type]);
        $setsBackgroundColor[$type] = array_reverse($setsBackgroundColor[$type]);
        $setsBorderColor[$type] = array_reverse($setsBorderColor[$type]);

        $cumulStat[$type]['nbMatchTotal'] = $cumulStat[$type]['nbMatchWon'] + $cumulStat[$type]['nbMatchLost'];
        if ($cumulStat[$type]['nbMatchTotal']) $cumulStat[$type]['percentWin'] = (int)(100 * $cumulStat[$type]['nbMatchWon'] / $cumulStat[$type]['nbMatchTotal']);
        $cumulStat[$type]['nbMatchWonTwoSets'] = $cumulStat[$type]['diffSetMatchWon'] - $cumulStat[$type]['nbMatchWon'];
        $cumulStat[$type]['nbMatchWonThreeSets'] = 2 * $cumulStat[$type]['nbMatchWon'] - $cumulStat[$type]['diffSetMatchWon'];
        $cumulStat[$type]['nbMatchLostTwoSets'] = - $cumulStat[$type]['diffSetMatchLost'] - $cumulStat[$type]['nbMatchLost'];
        $cumulStat[$type]['nbMatchLostThreeSets'] =  2 * $cumulStat[$type]['nbMatchLost'] + $cumulStat[$type]['diffSetMatchLost'];
      }

      return view('stat.show', compact('results', 'user','type', 'cumulStat', 'gender', 'opponentsWon', 'opponentsLost', 'opponentID', 'setsOpponent', 'setsDiffPoint', 'setsBackgroundColor', 'setsBorderColor', 'longuestWonSerie', 'longuestLostSerie'));
    }
}
