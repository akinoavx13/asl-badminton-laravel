<?php

namespace App\Http\Controllers;

use App\ChampionshipRanking;
use App\Http\Requests;
use App\Http\Requests\ScoreTournamentUpdateRequest;
use App\Http\Requests\ScoreUpdateRequest;
use App\Match;
use App\Period;
use App\Post;
use App\Score;
use App\Season;
use Illuminate\Http\Request;
use Redirect;

class ScoreController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //patterns
        $router->pattern('score_id', '[0-9]+');
        $router->pattern('pool_id', '[0-9]+');
        $router->pattern('firstTeamName', '[a-zA-Zéèàê&ïôç_-]+');
        $router->pattern('secondTeamName', '[a-zA-Zéèàê&ïôç_-]+');
        $router->pattern('anchor', '[0-9-a-z_]+');
        $router->pattern('anchorTournament', '[0-9-a-zA-Z_-]+');

        $router->get('update/{score_id}/{pool_id}/{firstTeamName}/{secondTeamName}/{anchor}', [
            'uses' => 'ScoreController@edit',
            'as'   => 'score.edit',
        ]);

        $router->post('update/{score_id}/{pool_id}/{firstTeamName}/{secondTeamName}/{anchor}', [
            'uses' => 'ScoreController@update',
            'as'   => 'score.update',
        ]);

        $router->get('update/{score_id}/{firstTeamName}/{secondTeamName}/{anchorTournament}', [
            'uses' => 'ScoreController@editTournament',
            'as'   => 'score.editTournament',
        ]);

        $router->post('update/{score_id}/{firstTeamName}/{secondTeamName}/{anchorTournament}', [
            'uses' => 'ScoreController@updateTournament',
            'as'   => 'score.updateTournament',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $score_id
     * @param $pool_id
     * @return \Illuminate\Http\Response
     */
    public function edit($score_id, $pool_id, $firstTeamName, $secondTeamName, $anchor)
    {

        $score = Score::findOrFail($score_id);

        $firstTeamName = str_replace('-', ' ', $firstTeamName);
        $secondTeamName = str_replace('-', ' ', $secondTeamName);

        return view('score.edit', compact('score', 'pool_id', 'firstTeamName', 'secondTeamName', 'anchor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScoreUpdateRequest|Request $request
     * @param $score_id
     * @return \Illuminate\Http\Response
     */
    public function update(ScoreUpdateRequest $request, $score_id, $pool_id, $firstTeamName, $secondTeamName, $anchor)
    {
        $score = Score::findOrFail($score_id);

        if ($request->exists('content')) {
            if ($request->get('content') != "" || $request->exists('photo')) {
                $post = Post::create([
                    'user_id'  => $this->user->id,
                    'score_id' => $score_id,
                    'content'  => nl2br($request->get('content')),
                    'photo'    => 0,
                ]);
                if ($request->exists('photo')) {
                    $post->update([
                        'photo' => $request->photo,
                    ]);
                }
            }
        }

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

        if ($request->exists('unplayed') && $request->unplayed) {
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

            $this->updateRankings($pool_id, $score->first_team_id, $score->second_team_id);


            return Redirect::to(route('championship.index') . '#' . $anchor)->with('success',
                'Le score a bien été enregistré !');
        }

        if ($request->exists('wo') && $request->wo == "my_wo") {
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

            $this->updateRankings($pool_id, $score->first_team_id, $score->second_team_id);

            return Redirect::to(route('championship.index') . '#' . $anchor)->with('success',
                'Le score a bien été enregistré !');
        }

        if ($request->exists('wo') && $request->wo == "his_wo") {
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

            $this->updateRankings($pool_id, $score->first_team_id, $score->second_team_id);

            return Redirect::to(route('championship.index') . '#' . $anchor)->with('success',
                'Le score a bien été enregistré !');
        }

        $message = $this->checkScore($firstSet, $secondSet, $thirdSet);

        if ($message == 'valid') {

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

            return Redirect::to(route('championship.index') . '#' . $anchor)->with('success',
                'Le score a bien été enregistré !');
        }
        return redirect()->back()->withInput($request->all())->with('error', $message);

    }

    public function editTournament($score_id, $firstTeamName, $secondTeamName, $anchorTournament)
    {
        $score = Score::findOrFail($score_id);

        $firstTeamName = str_replace('-', ' ', $firstTeamName);
        $secondTeamName = str_replace('-', ' ', $secondTeamName);

        return view('score.editTournament', compact('score', 'firstTeamName', 'secondTeamName', 'anchorTournament'));
    }

    public function updateTournament(ScoreTournamentUpdateRequest $request, $score_id, $firstTeamName, $secondTeamName, $anchorTournament)
    {
        $score = Score::findOrFail($score_id);

        $match = $score->match()->first();

        if ($match != null) {


            if ($request->exists('content')) {
                if ($request->get('content') != "" || $request->exists('photo')) {
                    $post = Post::create([
                        'user_id'  => $this->user->id,
                        'score_id' => $score_id,
                        'content'  => nl2br($request->get('content')),
                        'photo'    => 0,
                    ]);
                    if ($request->exists('photo')) {
                        $post->update([
                            'photo' => $request->photo,
                        ]);
                    }
                }
            }

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

            if ($request->exists('unplayed') && $request->unplayed) {
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

                return Redirect::to(route('tournament.index') . '##' . $anchorTournament)->with('success', 'Le score a bien été enregistré !');
            }

            if ($request->exists('wo') && $request->wo == "my_wo") {
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

                $this->setNextMatch($match, $score->second_team_id, $score->first_team_id);

                return Redirect::to(route('tournament.index') . '##' . $anchorTournament)->with('success', 'Le score a bien été enregistré !');
            }

            if ($request->exists('wo') && $request->wo == "his_wo") {
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

                $this->setNextMatch($match, $score->first_team_id, $score->second_team_id);
                return Redirect::to(route('tournament.index') . '##' . $anchorTournament)->with('success', 'Le score a bien été enregistré !');
            }

            $message = $this->checkScore($firstSet, $secondSet, $thirdSet);

            if ($message == 'valid') {

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

                if ($winner == "firstTeam") {
                    $this->setNextMatch($match, $score->first_team_id, $score->second_team_id);
                } else {
                    $this->setNextMatch($match, $score->second_team_id, $score->first_team_id);
                }
                return Redirect::to(route('tournament.index') . '##' . $anchorTournament)->with('success', 'Le score a bien été enregistré !');
            }
            return redirect()->back()->withInput($request->all())->with('error', $message);
        }
        return redirect()->back()->withInput($request->all())->with('error', 'Le score du match est null !');

    }

    private function setNextMatch($currentMatch, $winnerId, $looserId)
    {

        if ($currentMatch != null) {
            if ($currentMatch->next_match_winner_id != null) {
                $matchWinner = Match::findOrFail($currentMatch->next_match_winner_id);

                $firstTeamId = $matchWinner->first_team_id;
                $secondTeamId = $matchWinner->second_team_id;

                $matchWinner->update([
                    'first_team_id'  => $currentMatch->team_number_winner == 1 ? $winnerId : $firstTeamId,
                    'second_team_id' => $currentMatch->team_number_winner == 2 ? $winnerId : $secondTeamId,
                ]);

                $scoreId = $matchWinner->score_id;

                if ($scoreId == null && $matchWinner->first_team_id != null && $matchWinner->second_team_id != null) {
                    //on ne peut pas créer le score si les 2 joueurs ne sont pas connu.
                    //ici, on va créer le futur score mais avec les anciens joueurs,
                    //il faut attendre que le deuxième match soit joué pour créer le score.

                    $score = Score::create([
                        'first_team_id'  => $matchWinner->first_team_id,
                        'second_team_id' => $matchWinner->second_team_id,
                    ]);

                    $scoreId = $score->id;
                }

                $matchWinner->update([
                    'score_id' => $scoreId,
                ]);

            }

            if ($currentMatch->next_match_looser_id != null) {
                $matchLooser = Match::findOrFail($currentMatch->next_match_looser_id);

                $firstTeamId = $matchLooser->first_team_id;
                $secondTeamId = $matchLooser->second_team_id;

                $matchLooser->update([
                    'first_team_id'  => $currentMatch->team_number_looser == 1 ? $looserId : $firstTeamId,
                    'second_team_id' => $currentMatch->team_number_looser == 2 ? $looserId : $secondTeamId,
                ]);

                $scoreId = $matchLooser->score_id;

                if ($scoreId == null && $matchLooser->first_team_id != null && $matchLooser->second_team_id != null) {
                    //on ne peut pas créer le score si les 2 joueurs ne sont pas connu.
                    //ici, on va créer le futur score mais avec les anciens joueurs,
                    //il faut attendre que le deuxième match soit joué pour créer le score.

                    $score = Score::create([
                        'first_team_id'  => $matchLooser->first_team_id,
                        'second_team_id' => $matchLooser->second_team_id,
                    ]);

                    $scoreId = $score->id;
                }

                $matchLooser->update([
                    'score_id' => $scoreId,
                ]);
            }
        }

    }

    private function updateRankings($pool_id, $first_team_id, $second_team_id)
    {

        $activeSeason = Season::active()->first();

        if ($activeSeason != null) {
            $activePeriod = Period::getCurrentPeriod();
            if ($activePeriod != null) {

                $allScoresFirstTeam = Score::select('scores.*')
                    ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                    ->join('championship_rankings', 'championship_rankings.team_id', '=', 'teams.id')
                    ->where('championship_rankings.championship_pool_id', $pool_id)
                    ->where('scores.first_team_id', $first_team_id)
                    ->where('scores.created_at', '>=', $activePeriod->start->format('Y-m-d'))
                    ->where('scores.created_at', '<=', $activePeriod->end->format('Y-m-d'))
                    ->orWhere(function ($query) use ($first_team_id, $pool_id, $activePeriod) {
                        $query->where('scores.second_team_id', $first_team_id)
                            ->where('championship_rankings.championship_pool_id', $pool_id)
                            ->where('scores.created_at', '>=', $activePeriod->start->format('Y-m-d'))
                            ->where('scores.created_at', '<=', $activePeriod->end->format('Y-m-d'));
                    })
                    ->get();

                $allScoresSecondTeam = Score::select('scores.*')
                    ->join('teams', 'teams.id', '=', 'scores.first_team_id')
                    ->join('championship_rankings', 'championship_rankings.team_id', '=', 'teams.id')
                    ->where('championship_rankings.championship_pool_id', $pool_id)
                    ->where('scores.second_team_id', $second_team_id)
                    ->where('scores.created_at', '>=', $activePeriod->start->format('Y-m-d'))
                    ->where('scores.created_at', '<=', $activePeriod->end->format('Y-m-d'))
                    ->orWhere(function ($query) use ($second_team_id, $pool_id, $activePeriod) {
                        $query->where('scores.first_team_id', $second_team_id)
                            ->where('championship_rankings.championship_pool_id', $pool_id)
                            ->where('scores.created_at', '>=', $activePeriod->start->format('Y-m-d'))
                            ->where('scores.created_at', '<=', $activePeriod->end->format('Y-m-d'));
                    })
                    ->get();

                $rankingFirstTeam = ChampionshipRanking::where('team_id', $first_team_id)
                    ->where('championship_rankings.championship_pool_id', $pool_id)
                    ->first();

                $infoScoreFirstTeam = $this->getInfoRankings($allScoresFirstTeam, $first_team_id);
                if ($rankingFirstTeam !== null) {
                    $rankingFirstTeam->update([
                        'match_played'            => $infoScoreFirstTeam['match_played'],
                        'match_won'               => $infoScoreFirstTeam['match_won'],
                        'match_lost'              => $infoScoreFirstTeam['match_lost'],
                        'match_unplayed'          => $infoScoreFirstTeam['match_unplayed'],
                        'match_won_by_wo'         => $infoScoreFirstTeam['match_won_by_wo'],
                        'match_lost_by_wo'        => $infoScoreFirstTeam['match_lost_by_wo'],
                        'total_difference_set'    => $infoScoreFirstTeam['total_difference_set'],
                        'total_difference_points' => $infoScoreFirstTeam['total_difference_points'],
                        'total_points'            => $infoScoreFirstTeam['total_points'],
                    ]);
                }

                $rankingSecondTeam = ChampionshipRanking::where('team_id', $second_team_id)
                    ->where('championship_rankings.championship_pool_id', $pool_id)
                    ->first();

                $infoScoreSecondTeam = $this->getInfoRankings($allScoresSecondTeam, $second_team_id);
                if ($rankingSecondTeam !== null) {
                    $rankingSecondTeam->update([
                        'match_played'            => $infoScoreSecondTeam['match_played'],
                        'match_won'               => $infoScoreSecondTeam['match_won'],
                        'match_lost'              => $infoScoreSecondTeam['match_lost'],
                        'match_unplayed'          => $infoScoreSecondTeam['match_unplayed'],
                        'match_won_by_wo'         => $infoScoreSecondTeam['match_won_by_wo'],
                        'match_lost_by_wo'        => $infoScoreSecondTeam['match_lost_by_wo'],
                        'total_difference_set'    => $infoScoreSecondTeam['total_difference_set'],
                        'total_difference_points' => $infoScoreSecondTeam['total_difference_points'],
                        'total_points'            => $infoScoreSecondTeam['total_points'],
                    ]);
                }

                $this->calculRankings($pool_id);
            }
        }

    }

    private function getInfoRankings($scores, $team_id)
    {
        $infoRankings['match_played'] = 0;
        $infoRankings['match_unplayed'] = 0;
        $infoRankings['match_won'] = 0;
        $infoRankings['match_lost'] = 0;
        $infoRankings['match_won_by_wo'] = 0;
        $infoRankings['match_lost_by_wo'] = 0;
        $infoRankings['total_difference_set'] = 0;
        $infoRankings['total_difference_points'] = 0;
        $infoRankings['total_points'] = 0;

        if ($scores !== null) {
            foreach ($scores as $score) {

                $team_id == $score->first_team_id ? $isFirstTeam = true : $isFirstTeam = false;

                if ($score->hasUnplayed(true)) {
                    $infoRankings['match_unplayed'] += 1;
                } //gagné par wo
                elseif (($isFirstTeam && $score->hasHisWo(true)) || (!$isFirstTeam && $score->hasMyWo(true))) {
                    $infoRankings['match_played'] += 1;
                    $infoRankings['match_won_by_wo'] += 1;
                    $infoRankings['total_difference_set'] += 2;
                    $infoRankings['total_difference_points'] += 42;
                    $infoRankings['total_points'] += 3;
                } //perdu par wo
                elseif (($isFirstTeam && $score->hasMyWo(true)) || (!$isFirstTeam && $score->hasHisWo(true))) {
                    $infoRankings['match_played'] += 1;
                    $infoRankings['match_lost_by_wo'] += 1;
                    $infoRankings['total_difference_set'] -= 2;
                    $infoRankings['total_difference_points'] -= 42;
                    $infoRankings['total_points'] += 0;
                } //match gagné
                elseif ($isFirstTeam && $score->hasFirstTeamWin(true) || !$isFirstTeam && $score->hasSecondTeamWin(true)) {
                    $infoRankings['match_played'] += 1;
                    $infoRankings['match_won'] += 1;
                    if ($isFirstTeam) {
                        //on gagne le match en 2 ou 3 set si mon score est 0 au 3 set j'ai gagné en 2 set
                        if ($score->third_set_first_team == 0) {
                            $infoRankings['total_difference_set'] += 2;
                        } else {
                            $infoRankings['total_difference_set'] += 1;
                        }

                        $infoRankings['total_difference_points'] +=
                            $score->first_set_first_team - $score->first_set_second_team + $score->second_set_first_team - $score->second_set_second_team + $score->third_set_first_team - $score->third_set_second_team;
                    } else {
                        //on gagne le match en 2 ou 3 set si mon score est 0 au 3 set j'ai gagné en 2 set
                        if ($score->third_set_second_team == 0) {
                            $infoRankings['total_difference_set'] += 2;
                        } else {
                            $infoRankings['total_difference_set'] += 1;
                        }

                        $infoRankings['total_difference_points'] +=
                            $score->first_set_second_team - $score->first_set_first_team + $score->second_set_second_team - $score->second_set_first_team + $score->third_set_second_team - $score->third_set_first_team;
                    }
                    $infoRankings['total_points'] += 3;
                } //match perdu
                elseif ($isFirstTeam && $score->hasSecondTeamWin(true) || !$isFirstTeam && $score->hasFirstTeamWin(true)) {
                    $infoRankings['match_played'] += 1;
                    $infoRankings['match_lost'] += 1;
                    if ($isFirstTeam) {
                        //on perd le match en 2 ou 3 set si son score est 0 au 3 set j'ai perdu en 2 set
                        if ($score->third_set_second_team == 0) {
                            $infoRankings['total_difference_set'] -= 2;
                        } else {
                            $infoRankings['total_difference_set'] -= 1;
                        }

                        $infoRankings['total_difference_points'] +=
                            $score->first_set_first_team - $score->first_set_second_team + $score->second_set_first_team - $score->second_set_second_team + $score->third_set_first_team - $score->third_set_second_team;
                    } else {
                        //on perd le match en 2 ou 3 set si son score est 0 au 3 set j'ai perdu en 2 set
                        if ($score->third_set_first_team == 0) {
                            $infoRankings['total_difference_set'] -= 2;
                        } else {
                            $infoRankings['total_difference_set'] -= 1;
                        }

                        $infoRankings['total_difference_points'] +=
                            $score->first_set_second_team - $score->first_set_first_team + $score->second_set_second_team - $score->second_set_first_team + $score->third_set_second_team - $score->third_set_first_team;
                    }
                    $infoRankings['total_points'] += 1;
                }
            }
        }

        return $infoRankings;
    }

    private function calculRankings($pool_id)
    {

        $activeSeason = Season::active()->first();
        if ($activeSeason != null) {
            $activePeriod = Period::getCurrentPeriod();
            if ($activePeriod != null) {
                $rankings = ChampionshipRanking::where('championship_pool_id', $pool_id)
                    ->orderBy('total_points', 'desc')
                    ->orderBy('total_difference_set', 'desc')
                    ->orderBy('total_difference_points', 'desc')
                    ->get();

                //on cherche les exaequo. La structure exaequo est un tableau double dimension.
                // Le premier indice est le nombre total de points,
                // A 0 le deuxième indice donne ne nombre d'exaequo, à 1 il donne le ranking du premier exaequo, à 2 le deuxième...
                $allTotalPoints = [];
                $nbExaequo = [];

                // on commence par initaliser le tableau
                foreach ($rankings as $ranking) {
                    $nbExaequo[$ranking->total_points][0] = 0;
                }

                // on cherche le nombre de fois ou l'on trouve le meme nombre de points
                foreach ($rankings as $index => $ranking) {
                    $ranking->rank = $index + 1;
                    $allTotalPoints[$ranking->id] = $ranking->total_points;
                    $nbExaequo[$ranking->total_points][0] += 1;
                    $nbExaequo[$ranking->total_points][$nbExaequo[$ranking->total_points][0]] = $ranking;
                }

                //$rank = 1;
                //dd($rankings);
                foreach ($nbExaequo as $index => $exaequo) {
                    if ($exaequo[0] == 2) {
                        // deux exaequo qu'il faut departager au match particulier...
                        // on cherche si il y a un score entre ces 2 joueurs dans la periode, si il y a en plusieurs (erreurs de saisie) on prend le dernier

                        $score = Score::where('first_team_id', '=', $exaequo[1]->team_id)
                            ->where('second_team_id', '=', $exaequo[2]->team_id)
                            ->where('created_at', '>=', $activePeriod->start->format('Y-m-d'))
                            ->where('created_at', '<=', $activePeriod->end->format('Y-m-d'))
                            ->orderBy('created_at', 'desc')
                            ->orWhere(function ($query) use ($exaequo, $activePeriod, $ranking) {
                                $query->where('first_team_id', $exaequo[2]->team_id)
                                    ->where('second_team_id', $exaequo[1]->team_id)
                                    ->where('created_at', '>=', $activePeriod->start->format('Y-m-d'))
                                    ->where('created_at', '<=', $activePeriod->end->format('Y-m-d'))
                                    ->orderBy('created_at', 'desc');
                            })
                            ->first();
                        
                        if ($score != null) {
                            // il y a un score on cherche qui est le gagnant si c'est le deuxieme joueur on inverse le ranking
                            if ($score->my_wo) {
                                if ($exaequo[1]->team_id == $score->first_team_id) {
                                    $exaequo[1]->rank = $exaequo[1]->rank + 1;
                                    $exaequo[2]->rank = $exaequo[2]->rank - 1;
                                }

                            } elseif ($score->his_wo) {
                                if ($exaequo[1]->team_id == $score->second_team_id) {
                                    $exaequo[1]->rank = $exaequo[1]->rank + 1;
                                    $exaequo[2]->rank = $exaequo[2]->rank - 1;
                                }
                            } else {
                                $firstTeamWonSet = 0;
                                $secondTeamWonSet = 0;

                                if ($score->first_set_first_team > $score->first_set_second_team) {
                                    $firstTeamWonSet++;
                                } else {
                                    $secondTeamWonSet++;
                                }

                                if ($score->second_set_first_team > $score->second_set_second_team) {
                                    $firstTeamWonSet++;
                                } else {
                                    $secondTeamWonSet++;
                                }

                                if ($score->third_set_first_team != 0 &&
                                    $score->third_set_second_team != 0
                                ) {
                                    if ($score->third_set_first_team > $score->third_set_second_team) {
                                        $firstTeamWonSet++;
                                    } else {
                                        $secondTeamWonSet++;
                                    }
                                }
                                if ($firstTeamWonSet > $secondTeamWonSet) {
                                  // si le premier exaequo est le vainqueur on ne change pas le ranking
                                  // sinon on intervit le classement
                                    if ($exaequo[2]->team_id == $score->first_team_id) {
                                      //dd($exaequo[2]->rank);
                                      $exaequo[1]->rank = $exaequo[1]->rank + 1;
                                      $exaequo[2]->rank = $exaequo[2]->rank - 1;
                                      //dd($exaequo[2]->rank);
                                    }
                                } else {
                                    if ($exaequo[2]->team_id == $score->second_team_id) {
                                      $exaequo[1]->rank = $exaequo[1]->rank + 1;
                                      $exaequo[2]->rank = $exaequo[2]->rank - 1;
                                    }
                                }
                            }
                        } else {
                            // pas de score on garde le ranking donné par la requete
                            //$ranking->rank = $rank;
                        }

                    } else {
                        // ici pas besoin de vérifier si il y a 3 exaequo ou plus, car la requete est deja triée par difference de set puis de points
                        //$ranking->rank = $rank;
                    }

                    //$ranking->save();
                    //$rank++;
                }
                foreach ($rankings as $index => $ranking) {
                    $ranking->save();
                }
            }
        }
    }

    private function checkScore($firstSet, $secondSet, $thirdSet)
    {

        $result = 'valid';

        $winnerFirstSet = "";
        $winnerSecondSet = "";
        $needThirdSet = false;

        //Au moins un score du premier set doit être supérieur ou égale à 21
        if ($firstSet['firstTeam'] >= 21 || $firstSet['secondTeam'] >= 21) {

            if ($firstSet['firstTeam'] == 30 && $firstSet['secondTeam'] == 30) {
                return 'Erreur au premier set : impossible d\'avoir 30 à 30 !';
            }

            if (
                !($firstSet['firstTeam'] == 29 && $firstSet['secondTeam'] == 30) &&
                !($firstSet['firstTeam'] == 28 && $firstSet['secondTeam'] == 30) &&
                !($firstSet['firstTeam'] == 30 && $firstSet['secondTeam'] == 29) &&
                !($firstSet['firstTeam'] == 30 && $firstSet['secondTeam'] == 28)
            ) {
                //si le premier score est supérieur ou égale à 21, alors le deuxième score doit avoir 2 points d'écart
                if ($firstSet['firstTeam'] >= 21 && $firstSet['secondTeam'] >= 20) {
                    if (!(max($firstSet['firstTeam'], $firstSet['secondTeam']) - min($firstSet['firstTeam'],
                            $firstSet['secondTeam']) == 2)
                    ) {
                        return 'Erreur au premier set : il doit y avoir 2 points d\'écart !';
                    }
                }

                //si le deuxième score est supérieur ou égale à 21, alors le premier score doit avoir 2 points d'écart
                //sauf le score vaut 30
                if ($firstSet['secondTeam'] >= 21 && $firstSet['firstTeam'] >= 20) {
                    if (!(max($firstSet['firstTeam'], $firstSet['secondTeam']) - min($firstSet['firstTeam'],
                            $firstSet['secondTeam']) == 2)
                    ) {
                        return 'Erreur au premier set : il doit y avoir 2 points d\'écart !';
                    }
                }
            }

            //gagnant du set
            if ($firstSet['firstTeam'] > $firstSet['secondTeam']) {
                $winnerFirstSet = 'firstTeam';
            } else {
                $winnerFirstSet = 'secondTeam';
            }
        } else {
            return 'Erreur au premier set : un des 2 scores doit être supèrieur à 21 !';
        }

        //Au moins un score du deuxième set doit être supérieur ou égale à 21
        if ($secondSet['firstTeam'] >= 21 || $secondSet['secondTeam'] >= 21) {
            if ($secondSet['firstTeam'] == 30 && $secondSet['secondTeam'] == 30) {
                return 'Erreur au deuxième set : impossible d\'avoir 30 à 30 !';
            }

            if (
                !($secondSet['firstTeam'] == 29 && $secondSet['secondTeam'] == 30) &&
                !($secondSet['firstTeam'] == 28 && $secondSet['secondTeam'] == 30) &&
                !($secondSet['firstTeam'] == 30 && $secondSet['secondTeam'] == 29) &&
                !($secondSet['firstTeam'] == 30 && $secondSet['secondTeam'] == 28)
            ) {
                //si le premier score est supérieur ou égale à 21, alors le deuxième score doit avoir 2 points d'écart
                if ($secondSet['firstTeam'] >= 21 && $secondSet['secondTeam'] >= 20) {
                    if (!(max($secondSet['firstTeam'], $secondSet['secondTeam']) - min($secondSet['firstTeam'],
                            $secondSet['secondTeam']) == 2)
                    ) {
                        return 'Erreur au deuxième set : il doit y avoir 2 points d\'écart !';
                    }
                }

                //si le deuxième score est supérieur ou égale à 21, alors le premier score doit avoir 2 points d'écart
                //sauf le score vaut 30
                if ($secondSet['secondTeam'] >= 21 && $secondSet['firstTeam'] >= 20) {
                    if (!(max($secondSet['firstTeam'], $secondSet['secondTeam']) - min($secondSet['firstTeam'],
                            $secondSet['secondTeam']) == 2)
                    ) {
                        return 'Erreur au deuxième set : il doit y avoir 2 points d\'écart !';
                    }
                }
            }

            //gagnant du set
            if ($secondSet['firstTeam'] > $secondSet['secondTeam']) {
                $winnerSecondSet = 'firstTeam';
            } else {
                $winnerSecondSet = 'secondTeam';
            }

        } else {
            return 'Erreur au deuxième set : un des 2 scores doit être supèrieur à 21 !';
        }

        if (($winnerFirstSet === 'firstTeam' && $winnerSecondSet === 'secondTeam') ||
            ($winnerFirstSet === 'secondTeam' && $winnerSecondSet === 'firstTeam')
        ) {
            $needThirdSet = true;
        }

        if ($needThirdSet && $thirdSet['firstTeam'] == "" || $thirdSet['secondTeam'] == "") {
            return 'Il faut un troisième set pour déterminer le vainqueur !';
        }


        if ($needThirdSet) {
            //Au moins un score du deuxième set doit être supérieur ou égale à 21
            if ($thirdSet['firstTeam'] >= 21 || $thirdSet['secondTeam'] >= 21) {
                if ($thirdSet['firstTeam'] == 30 && $thirdSet['secondTeam'] == 30) {
                    return 'Erreur au troisième set : impossible d\'avoir 30 à 30 !';
                }

                if (
                    !($thirdSet['firstTeam'] == 29 && $thirdSet['secondTeam'] == 30) &&
                    !($thirdSet['firstTeam'] == 28 && $thirdSet['secondTeam'] == 30) &&
                    !($thirdSet['firstTeam'] == 30 && $thirdSet['secondTeam'] == 29) &&
                    !($thirdSet['firstTeam'] == 30 && $thirdSet['secondTeam'] == 28)
                ) {
                    //si le premier score est supérieur ou égale à 21, alors le deuxième score doit avoir 2 points d'écart
                    if ($thirdSet['firstTeam'] >= 21 && $thirdSet['secondTeam'] >= 20) {
                        if (!(max($thirdSet['firstTeam'], $thirdSet['secondTeam']) - min($thirdSet['firstTeam'],
                                $thirdSet['secondTeam']) == 2)
                        ) {
                            return 'Erreur au troisième set : il doit y avoir 2 points d\'écart !';
                        }
                    }

                    //si le deuxième score est supérieur ou égale à 21, alors le premier score doit avoir 2 points d'écart
                    //sauf le score vaut 30
                    if ($thirdSet['secondTeam'] >= 21 && $thirdSet['firstTeam'] >= 20) {
                        if (!(max($thirdSet['firstTeam'], $thirdSet['secondTeam']) - min($thirdSet['firstTeam'],
                                $thirdSet['secondTeam']) == 2)
                        ) {
                            return 'Erreur au troisième set : il doit y avoir 2 points d\'écart !';
                        }
                    }
                }
            } else {
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

        if ($firstSet['firstTeam'] > $firstSet['secondTeam']) {
            $winnerFirstSet = "firstTeam";
        } elseif ($firstSet['firstTeam'] < $firstSet['secondTeam']) {
            $winnerFirstSet = "secondTeam";
        }

        if ($secondSet['firstTeam'] > $secondSet['secondTeam']) {
            $winnerSecondSet = "firstTeam";
        } elseif ($secondSet['firstTeam'] < $secondSet['secondTeam']) {
            $winnerSecondSet = "secondTeam";
        }

        if ($winnerFirstSet == $winnerSecondSet) {
            return $winnerFirstSet;
        } else {
            if ($thirdSet['firstTeam'] > $thirdSet['secondTeam']) {
                $winnerThirdSet = "firstTeam";
            } elseif ($thirdSet['firstTeam'] < $thirdSet['secondTeam']) {
                $winnerThirdSet = "secondTeam";
            }

            if ($winnerFirstSet == $winnerThirdSet) {
                return $winnerFirstSet;
            } else {
                return $winnerSecondSet;
            }

        }
    }
}
