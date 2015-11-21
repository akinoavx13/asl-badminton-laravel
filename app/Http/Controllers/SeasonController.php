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
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SeasonController@index',
            'as'         => 'season.index',
        ]);

        //season edit
        $router->get('/edit/{season_id}', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SeasonController@edit',
            'as'         => 'season.edit',
        ]);

        //season update
        $router->post('/edit/{season_id}', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SeasonController@update',
            'as'         => 'season.update',
        ]);

        //season delete
        $router->get('/delete/{season_id}', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SeasonController@delete',
            'as'         => 'season.delete',
        ]);

        //season create
        $router->get('/create', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SeasonController@create',
            'as'         => 'season.create',
        ]);

        //season store
        $router->post('/store', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SeasonController@store',
            'as'         => 'season.store',
        ]);

        //season change active attribute
        $router->get('/change_active_attribute/{season_id}', [
            'middleware' => ['auth', 'admin'],
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

        $season->update([
            'name'   => $request->name,
        ]);

        flash()->success('Sauvegardée !', '');

        return redirect()->route('season.index');
    }

    public function delete($season_id)
    {
        $season = Season::findOrFail($season_id);
        $season->delete();

        flash()->success('Supprimée !', '');

        return redirect()->back();
    }

    public function create()
    {
        $season = new Season();

        return view('season.create', compact('season'));
    }

    public function store(SeasonStoreRequest $request)
    {
        Season::create([
            'name'   => $request->name,
            'active' => false,
        ]);

        flash()->success('Créée !', '');

        return redirect()->route('season.index');
    }

    public function changeActiveAttribute($season_id)
    {
        $seasonSelected = Season::findOrFail($season_id);

        foreach (Season::all() as $season)
        {
            if ($season->hasActive(true))
            {
                $season->update([
                    'active' => false,
                ]);
            }
        }

        $seasonSelected->update([
            'active' => true,
        ]);

        flash()->success('Sauvegardée !', '');

        return redirect()->route('season.index');
    }

}
