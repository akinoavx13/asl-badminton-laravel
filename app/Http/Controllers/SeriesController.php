<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SeriesUpdateRequest;
use App\Match;
use App\Score;
use App\Series;
use App\Tournament;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public static function routes($router)
    {

        $router->get('create', [
            'uses' => 'SeriesController@create',
            'as'   => 'series.create',
        ]);

        $router->post('create', [
            'uses' => 'SeriesController@store',
            'as'   => 'series.store',
        ]);
    }

    public function create()
    {
        $tournament = Tournament::lasted()->first();

        if ($tournament != null) {
            return view('series.create', compact('tournament'));
        }

        return redirect()->back()->with('error', 'Il faut une saison active !');
    }

    public function store(SeriesUpdateRequest $request)
    {

        foreach ($request->category as $serie_id => $category) {
            if (pow(2, $request->number_rank[$serie_id] - 1) > $request->number_matches_rank_1[$serie_id]) {
                return redirect()->back()->withInput()->with('error', 'Le nombre de rang est incohérent avec le nombre de match de rang 1 pour la série n° ' . $request->display_order[$serie_id]);
            }
        }

        foreach ($request->category as $serie_id => $category) {
            $serie = Series::findOrFail($serie_id);

            $serie->update([
                'category'              => $request->category[$serie_id],
                'display_order'         => $request->display_order[$serie_id],
                'name'                  => $request->name[$serie_id],
                'number_matches_rank_1' => $request->number_matches_rank_1[$serie_id],
                'number_rank'           => $request->number_rank[$serie_id],
            ]);

            $nbMatchRank = $serie->number_matches_rank_1;
            $matchNumber = 1;

            for ($rankNumber = 1; $rankNumber <= $serie->number_rank; $rankNumber++) {
                for ($j = 1; $j <= $nbMatchRank; $j++) {
                    Match::create([
                        'matches_number_in_table' => $matchNumber,
                        'first_team_id'           => null,
                        'second_team_id'          => null,
                        'series_rank'             => $rankNumber,
                        'series_id'               => $serie_id,
                        'next_match_winner_id'    => null,
                        'next_match_looser_id'    => null,
                        'team_number_winner'      => null,
                        'team_number_looser'      => null,
                        'score_id'                => null
                    ]);

                    $matchNumber++;
                }
                $nbMatchRank /= 2;
            }

            $nbMatchRank = $serie->number_matches_rank_1;
            $matchNumber = 1;

            for ($rankNumber = 1; $rankNumber <= $serie->number_rank; $rankNumber++) {
                for ($j = 1; $j <= $nbMatchRank; $j++) {
                    $currentMatch = Match::where('matches_number_in_table', $matchNumber)
                        ->where('series_id', $serie_id)
                        ->first();

                    $matchNumberOfTheWinner = $serie->number_matches_rank_1 + floor(($matchNumber + 1) / 2);
                    $winnerMatch = Match::where('matches_number_in_table', $matchNumberOfTheWinner)
                        ->where('series_id', $serie_id)
                        ->first();

                    $teamNumberOfTheWinner = floor(($matchNumber + 1) / 2) == ($matchNumber + 1) / 2 ? 2 : 1;

                    if ($currentMatch != null && $winnerMatch != null) {
                        $currentMatch->update([
                            'next_match_winner_id' => $winnerMatch->id,
                            'team_number_winner'   => $teamNumberOfTheWinner
                        ]);
                    }

                    $matchNumber++;
                }
                $nbMatchRank /= 2;
            }

        }

        return redirect()->route('tournament.index')->with('success', "Le tournoi vient d'être créé !");
    }
}
