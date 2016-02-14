<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreUpdateRequest;
use App\Score;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScoreController extends Controller
{

    public static function routes($router)
    {
        //patterns
        $router->pattern('score_id', '[0-9]+');
        $router->pattern('pool_id', '[0-9]+');
        $router->pattern('firstTeamName', '[a-zA-Zéèàê&ïô_-]+');
        $router->pattern('secondTeamName', '[a-zA-Zéèàê&ïô_-]+');

        $router->get('create/{score_id}/{pool_id}/{firstTeamName}/{secondTeamName}', [
            'uses' => 'ScoreController@edit',
            'as'   => 'score.edit',
        ]);

        $router->post('create/{score_id}/{pool_id}/{firstTeamName}/{secondTeamName}', [
            'uses' => 'ScoreController@update',
            'as'   => 'score.update',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $score_id
     * @param $pool_id
     * @return \Illuminate\Http\Response
     */
    public function edit($score_id, $pool_id, $firstTeamName, $secondTeamName)
    {
        $score = Score::findOrFail($score_id);

        $firstTeamName = str_replace('-', ' ', $firstTeamName);
        $secondTeamName = str_replace('-', ' ', $secondTeamName);

        return view('score.edit', compact('score', 'pool_id', 'firstTeamName', 'secondTeamName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScoreUpdateRequest|Request $request
     * @param $score_id
     * @return \Illuminate\Http\Response
     */
    public function update(ScoreUpdateRequest $request, $score_id, $pool_id, $firstTeamName, $secondTeamName)
    {

        $score = Score::findOrFail($score_id);

        $firstSet = [
            'firstTeam'  => $request->first_set_first_team,
            'secondTeam' => $request->first_set_second_team,
        ];

        $secondSet = [
            'firstTeam'  => $request->second_set_first_team,
            'secondTeam' => $request->second_set_second_team,
        ];

        $thirdSet = [
            'firstTeam'  => $request->third_set_first_team,
            'secondTeam' => $request->third_set_second_team,
        ];

        if ($request->exists('unplayed') && $request->unplayed)
        {
            $score->update([
                'first_set_first_team'   => 0,
                'first_set_second_team'  => 0,
                'second_set_first_team'  => 0,
                'second_set_second_team' => 0,
                'third_set_first_team'   => 0,
                'third_set_second_team'  => 0,
                'my_wo'                  => false,
                'his_wo'                 => false,
                'unplayed'               => true,
                'display'                => true,
                'first_team_win'         => false,
                'second_team_win'        => false,
            ]);

            return redirect()->route('championship.index')->with('success', 'Le score est bien enregistré !');
        }

        if ($request->exists('my_wo') && $request->my_wo == "my_wo")
        {
            $score->update([
                'first_set_first_team'   => 0,
                'first_set_second_team'  => 21,
                'second_set_first_team'  => 0,
                'second_set_second_team' => 21,
                'third_set_first_team'   => 0,
                'third_set_second_team'  => 0,
                'my_wo'                  => true,
                'his_wo'                 => false,
                'unplayed'               => false,
                'display'                => true,
                'first_team_win'         => false,
                'second_team_win'        => true,
            ]);

            return redirect()->route('championship.index')->with('success', 'Le score est bien enregistré !');
        }

        if ($request->exists('his_wo') && $request->his_wo == "his_wo")
        {
            $score->update([
                'first_set_first_team'   => 21,
                'first_set_second_team'  => 0,
                'second_set_first_team'  => 21,
                'second_set_second_team' => 0,
                'third_set_first_team'   => 0,
                'third_set_second_team'  => 0,
                'my_wo'                  => false,
                'his_wo'                 => true,
                'unplayed'               => false,
                'display'                => true,
                'first_team_win'         => true,
                'second_team_win'        => false,
            ]);

            return redirect()->route('championship.index')->with('success', 'Le score est bien enregistré !');
        }

        $message = $this->checkScore($firstSet, $secondSet, $thirdSet);

        if ($message == 'valid')
        {

            $winner = $this->getWinner($firstSet, $secondSet, $thirdSet);

            $score->update([
                'first_set_first_team'   => $request->first_set_first_team,
                'first_set_second_team'  => $request->first_set_second_team,
                'second_set_first_team'  => $request->second_set_first_team,
                'second_set_second_team' => $request->second_set_second_team,
                'third_set_first_team'   => $request->third_set_first_team != "" ? $request->third_set_first_team :
                    null,
                'third_set_second_team'  => $request->third_set_second_team != "" ? $request->third_set_second_team :
                    null,
                'my_wo'                  => false,
                'his_wo'                 => false,
                'unplayed'               => false,
                'display'                => true,
                'first_team_win'         => $winner == "firstTeam" ? true : false,
                'second_team_win'        => $winner == "secondTeam" ? true : false,
            ]);

            $this->updateRankings($pool_id, $score->first_team_id, $score->second_team_id);

            return redirect()->route('championship.index')->with('success', 'Le score est bien enregistré !');
        }
        else
        {
            return redirect()->back()->withInput($request->all())->with('error', $message);
        }

    }

    private function checkScore($firstSet, $secondSet, $thirdSet)
    {

        $result = 'valid';

        $winnerFirstSet = "";
        $winnerSecondSet = "";
        $needThirdSet = false;

        //Au moins un score du premier set doit être supérieur ou égale à 21
        if ($firstSet['firstTeam'] >= 21 || $firstSet['secondTeam'] >= 21)
        {

            if ($firstSet['firstTeam'] == 30 && $firstSet['secondTeam'] == 30)
            {
                return 'Erreur au premier set : impossible d\'avoir 30 à 30 !';
            }

            if (
                ! ($firstSet['firstTeam'] == 29 && $firstSet['secondTeam'] == 30) &&
                ! ($firstSet['firstTeam'] == 28 && $firstSet['secondTeam'] == 30) &&
                ! ($firstSet['firstTeam'] == 30 && $firstSet['secondTeam'] == 29) &&
                ! ($firstSet['firstTeam'] == 30 && $firstSet['secondTeam'] == 28)
            )
            {
                //si le premier score est supérieur ou égale à 21, alors le deuxième score doit avoir 2 points d'écart
                if ($firstSet['firstTeam'] >= 21 && $firstSet['secondTeam'] >= 20)
                {
                    if (! (max($firstSet['firstTeam'], $firstSet['secondTeam']) - min($firstSet['firstTeam'],
                            $firstSet['secondTeam']) == 2)
                    )
                    {
                        return 'Erreur au premier set : il doit y avoir 2 points d\'écart !';
                    }
                }

                //si le deuxième score est supérieur ou égale à 21, alors le premier score doit avoir 2 points d'écart
                //sauf le score vaut 30
                if ($firstSet['secondTeam'] >= 21 && $firstSet['firstTeam'] >= 20)
                {
                    if (! (max($firstSet['firstTeam'], $firstSet['secondTeam']) - min($firstSet['firstTeam'],
                            $firstSet['secondTeam']) == 2)
                    )
                    {
                        return 'Erreur au premier set : il doit y avoir 2 points d\'écart !';
                    }
                }
            }

            //gagnant du set
            if ($firstSet['firstTeam'] > $firstSet['secondTeam'])
            {
                $winnerFirstSet = 'firstTeam';
            }
            else
            {
                $winnerFirstSet = 'secondTeam';
            }
        }
        else
        {
            return 'Erreur au premier set : un des 2 scores doit être supèrieur à 21 !';
        }

        //Au moins un score du deuxième set doit être supérieur ou égale à 21
        if ($secondSet['firstTeam'] >= 21 || $secondSet['secondTeam'] >= 21)
        {
            if ($secondSet['firstTeam'] == 30 && $secondSet['secondTeam'] == 30)
            {
                return 'Erreur au deuxième set : impossible d\'avoir 30 à 30 !';
            }

            if (
                ! ($secondSet['firstTeam'] == 29 && $secondSet['secondTeam'] == 30) &&
                ! ($secondSet['firstTeam'] == 28 && $secondSet['secondTeam'] == 30) &&
                ! ($secondSet['firstTeam'] == 30 && $secondSet['secondTeam'] == 29) &&
                ! ($secondSet['firstTeam'] == 30 && $secondSet['secondTeam'] == 28)
            )
            {
                //si le premier score est supérieur ou égale à 21, alors le deuxième score doit avoir 2 points d'écart
                if ($secondSet['firstTeam'] >= 21 && $secondSet['secondTeam'] >= 20)
                {
                    if (! (max($secondSet['firstTeam'], $secondSet['secondTeam']) - min($secondSet['firstTeam'],
                            $secondSet['secondTeam']) == 2)
                    )
                    {
                        return 'Erreur au deuxième set : il doit y avoir 2 points d\'écart !';
                    }
                }

                //si le deuxième score est supérieur ou égale à 21, alors le premier score doit avoir 2 points d'écart
                //sauf le score vaut 30
                if ($secondSet['secondTeam'] >= 21 && $secondSet['firstTeam'] >= 20)
                {
                    if (! (max($secondSet['firstTeam'], $secondSet['secondTeam']) - min($secondSet['firstTeam'],
                            $secondSet['secondTeam']) == 2)
                    )
                    {
                        return 'Erreur au deuxième set : il doit y avoir 2 points d\'écart !';
                    }
                }
            }

            //gagnant du set
            if ($secondSet['firstTeam'] > $secondSet['secondTeam'])
            {
                $winnerSecondSet = 'firstTeam';
            }
            else
            {
                $winnerSecondSet = 'secondTeam';
            }

        }
        else
        {
            return 'Erreur au deuxième set : un des 2 scores doit être supèrieur à 21 !';
        }

        if (($winnerFirstSet === 'firstTeam' && $winnerSecondSet === 'secondTeam') ||
            ($winnerFirstSet === 'secondTeam' && $winnerSecondSet === 'firstTeam')
        )
        {
            $needThirdSet = true;
        }

        if (
            $needThirdSet &&
            $thirdSet['firstTeam'] === "" || $thirdSet['secondTeam'] === "" &&
            ($winnerFirstSet === 'firstTeam' && $winnerSecondSet === 'secondTeam') ||
            ($winnerFirstSet === 'secondTeam' && $winnerSecondSet === 'firstTeam')
        )
        {
            return 'Il faut un troisième set pour déterminer le vainqueur !';
        }


        if ($needThirdSet)
        {
            //Au moins un score du deuxième set doit être supérieur ou égale à 21
            if ($thirdSet['firstTeam'] >= 21 || $thirdSet['secondTeam'] >= 21)
            {
                if ($thirdSet['firstTeam'] == 30 && $thirdSet['secondTeam'] == 30)
                {
                    return 'Erreur au troisième set : impossible d\'avoir 30 à 30 !';
                }

                if (
                    ! ($thirdSet['firstTeam'] == 29 && $thirdSet['secondTeam'] == 30) &&
                    ! ($thirdSet['firstTeam'] == 28 && $thirdSet['secondTeam'] == 30) &&
                    ! ($thirdSet['firstTeam'] == 30 && $thirdSet['secondTeam'] == 29) &&
                    ! ($thirdSet['firstTeam'] == 30 && $thirdSet['secondTeam'] == 28)
                )
                {
                    //si le premier score est supérieur ou égale à 21, alors le deuxième score doit avoir 2 points d'écart
                    if ($thirdSet['firstTeam'] >= 21 && $thirdSet['secondTeam'] >= 20)
                    {
                        if (! (max($thirdSet['firstTeam'], $thirdSet['secondTeam']) - min($thirdSet['firstTeam'],
                                $thirdSet['secondTeam']) == 2)
                        )
                        {
                            return 'Erreur au troisième set : il doit y avoir 2 points d\'écart !';
                        }
                    }

                    //si le deuxième score est supérieur ou égale à 21, alors le premier score doit avoir 2 points d'écart
                    //sauf le score vaut 30
                    if ($thirdSet['secondTeam'] >= 21 && $thirdSet['firstTeam'] >= 20)
                    {
                        if (! (max($thirdSet['firstTeam'], $thirdSet['secondTeam']) - min($thirdSet['firstTeam'],
                                $thirdSet['secondTeam']) == 2)
                        )
                        {
                            return 'Erreur au troisième set : il doit y avoir 2 points d\'écart !';
                        }
                    }
                }
            }
            else
            {
                return 'Erreur au troisième set : un des 2 scores doit être supèrieur à 21 !';
            }
        }

        return $result;
    }

    private function getWinner($firstSet, $secondSet, $thirdSet)
    {
        $winnerFirstSet = null;
        $winnerSecondSet = null;
        $winnerThirdSet = null;

        if ($firstSet['firstTeam'] > $firstSet['secondTeam'])
        {
            $winnerFirstSet = "firstTeam";
        }
        elseif ($firstSet['firstTeam'] < $firstSet['secondTeam'])
        {
            $winnerFirstSet = "secondTeam";
        }

        if ($secondSet['firstTeam'] > $secondSet['secondTeam'])
        {
            $winnerSecondSet = "firstTeam";
        }
        elseif ($secondSet['firstTeam'] < $secondSet['secondTeam'])
        {
            $winnerSecondSet = "secondTeam";
        }

        if ($winnerFirstSet == $winnerSecondSet)
        {
            return $winnerFirstSet;
        }
        else
        {
            if ($thirdSet['firstTeam'] > $thirdSet['secondTeam'])
            {
                $winnerThirdSet = "firstTeam";
            }
            elseif ($thirdSet['firstTeam'] < $thirdSet['secondTeam'])
            {
                $winnerThirdSet = "secondTeam";
            }

            if ($winnerFirstSet == $winnerThirdSet)
            {
                return $winnerFirstSet;
            }
            else
            {
                return $winnerSecondSet;
            }

        }
    }

    private function updateRankings($pool_id, $first_team_id, $second_team_id)
    {
        $allScoresFirstTeam = Score::select('scores.*')
            ->join('teams', 'teams.id', '=', 'scores.first_team_id')
            ->join('championship_rankings', 'championship_rankings.team_id', '=', 'teams.id')
            ->where('championship_rankings.championship_pool_id', $pool_id)
            ->where('scores.first_team_id', $first_team_id)
            ->get();

        $allScoresSecondTeam = Score::select('scores.*')
            ->join('teams', 'teams.id', '=', 'scores.first_team_id')
            ->join('championship_rankings', 'championship_rankings.team_id', '=', 'teams.id')
            ->where('championship_rankings.championship_pool_id', $pool_id)
            ->where('scores.second_team_id', $second_team_id)
            ->get();

    }
}
