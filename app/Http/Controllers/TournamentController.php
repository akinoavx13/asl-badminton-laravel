<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TournamentStoreRequest;
use App\Season;
use App\Series;
use App\Tournament;

class TournamentController extends Controller
{
    public static function routes($router)
    {

        $router->get('create', [
            'middleware' => 'admin',
            'uses'       => 'TournamentController@create',
            'as'         => 'tournament.create',
        ]);

        $router->post('create', [
            'middleware' => 'admin',
            'uses'       => 'TournamentController@store',
            'as'         => 'tournament.store',
        ]);
    }

    public function create()
    {

        $tournament = new Tournament();

        return view('tournament.create', compact('tournament'));
    }

    public function store(TournamentStoreRequest $request)
    {

        $season = Season::active()->first();

        if ($season !== null)
        {
            $tournament = Tournament::create([
                'start'         => $request->start,
                'end'           => $request->end,
                'name'          => $request->name,
                'series_number' => $request->series_number,
                'season_id'     => $season->id,
            ]);

            for ($i = 1; $i <= $tournament->series_number; $i++)
            {

                Series::create([
                    'category'              => 'S',
                    'display_order'         => $i,
                    'name'                  => '',
                    'number_matches_rank_1' => 8,
                    'number_rank'           => 4,
                    'tournament_id'         => $tournament->id,
                ]);
            }

            return redirect()->route('series.create')->with('succes', "Le tournoi vient d'être créé !");

        }

        return redirect()->route('home.index')->with('error', "Pour créer un tournoi il faut d'abord une saison !");

    }
}
