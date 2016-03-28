<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentStoreRequest;
use App\Season;
use App\Tournament;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
            Tournament::create([
                'start'        => $request->start,
                'end'          => $request->end,
                'name'         => $request->name,
                'table_number' => $request->table_number,
                'season_id'    => $season->id,
            ]);

            return redirect()->route('home.index')->with('succes', "Le tournoi vient d'être créé !");

        }

        return redirect()->route('home.index')->with('error', "Pour créer un tournoi il faut d'abord une saison !");

    }
}
