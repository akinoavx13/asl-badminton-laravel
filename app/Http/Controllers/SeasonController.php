<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SeasonStoreRequest;
use App\Http\Requests\SeasonUpdateRequest;
use App\Season;

class SeasonController extends Controller
{
    public static function routes($router)
    {
        //paterns
        $router->pattern('season_id', '[0-9]+');

        //season list
        $router->get('/index', [
            'uses'       => 'SeasonController@index',
            'as'         => 'season.index',
        ]);

        //season edit
        $router->get('/edit/{season_id}', [
            'uses'       => 'SeasonController@edit',
            'as'         => 'season.edit',
        ]);

        //season update
        $router->post('/edit/{season_id}', [
            'uses'       => 'SeasonController@update',
            'as'         => 'season.update',
        ]);

        //season delete
        $router->get('/delete/{season_id}', [
            'uses'       => 'SeasonController@delete',
            'as'         => 'season.delete',
        ]);

        //season create
        $router->get('/create', [
            'uses'       => 'SeasonController@create',
            'as'         => 'season.create',
        ]);

        //season store
        $router->post('/store', [
            'uses'       => 'SeasonController@store',
            'as'         => 'season.store',
        ]);

        //season change active attribute
        $router->get('/change_active_attribute/{season_id}', [
            'uses'       => 'SeasonController@changeActiveAttribute',
            'as'         => 'season.change_active_attribute',
        ]);
    }

    public function index()
    {
        $seasons = Season::all();

        return view('season.index', compact('seasons'));
    }

    public function edit($season_id)
    {
        $season = Season::findOrFail($season_id);

        return view('season.edit', compact('season'));
    }

    public function update(SeasonUpdateRequest $request, $season_id)
    {
        $season = Season::findOrFail($season_id);

        //on ne peut pas choisir si elle est active ou pas
        $season->update([
            'name'   => $request->name,
        ]);

        return redirect()->route('season.index')->with('success', "Les modifications sont bien prise en compte !");
    }

    public function delete($season_id)
    {
        $season = Season::findOrFail($season_id);
        $season->delete();

        return redirect()->route('season.index')->with('success', "La saison $season vient d'être supprimée !");
    }

    public function create()
    {
        $season = new Season();

        return view('season.create', compact('season'));
    }

    public function store(SeasonStoreRequest $request)
    {
        $season = Season::create([
            'name'   => $request->name,
            'active' => false,
        ]);

        return redirect()->route('season.index')->with('success', "La saison $season vient d'être créée !");
    }

    public function changeActiveAttribute($season_id)
    {
        $seasonSelected = Season::findOrFail($season_id);

        //on prend toutes les saison active
        foreach (Season::active()->get() as $season)
        {
            $season->update([
                'active' => false,
            ]);
        }

        $seasonSelected->update([
            'active' => true,
        ]);

        return redirect()->route('season.index')->with('success', "La saison $season est active !");
    }

}
