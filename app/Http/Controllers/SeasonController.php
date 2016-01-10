<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SeasonStoreRequest;
use App\Http\Requests\SeasonUpdateRequest;
use App\Season;

/**
 * Manage seasons
 *
 * Class SeasonController
 * @package App\Http\Controllers
 */
class SeasonController extends Controller
{
    /**
     * @param $router
     */
    public static function routes($router)
    {
        //patterns
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

    /**
     * View all seasons
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $seasons = Season::all();

        return view('season.index', compact('seasons'));
    }

    /**
     * View form to create the season
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $season = new Season();

        return view('season.create', compact('season'));
    }

    /**
     * Store the season created
     *
     * @param SeasonStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SeasonStoreRequest $request)
    {
        $season = Season::create([
            'name'   => $request->name,
            'active' => false,
        ]);

        return redirect()->route('season.index')->with('success', "La saison $season vient d'être créée !");
    }

    /**
     * View form to edit the season
     *
     * @param $season_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($season_id)
    {
        $season = Season::findOrFail($season_id);

        return view('season.edit', compact('season'));
    }

    /**
     * Update the season edited
     *
     * @param SeasonUpdateRequest $request
     * @param $season_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SeasonUpdateRequest $request, $season_id)
    {
        $season = Season::findOrFail($season_id);

        //on ne peut pas choisir si elle est active ou pas
        $season->update([
            'name'   => $request->name,
        ]);

        return redirect()->route('season.index')->with('success', "Les modifications sont bien prise en compte !");
    }

    /**
     * Delete one season
     *
     * @param $season_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($season_id)
    {
        $season = Season::findOrFail($season_id);
        $season->delete();

        return redirect()->route('season.index')->with('success', "La saison $season vient d'être supprimée !");
    }

    /**
     * Change season to active, just one season can be active
     *
     * @param $season_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeActiveAttribute($season_id)
    {
        $seasonSelected = Season::findOrFail($season_id);

        //on prend toutes les saisons actives
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
