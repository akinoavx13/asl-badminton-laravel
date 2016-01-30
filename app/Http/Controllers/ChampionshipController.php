<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChampionshipStoreRequest;
use App\Period;
use App\Season;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChampionshipController extends Controller
{

    /**
     * @param $router
     */
    public static function routes($router)
    {
        //championship create
        $router->get('create', [
            'uses' => 'ChampionshipController@create',
            'as'   => 'championship.create',
        ]);

        //championship store
        $router->post('store', [
            'uses' => 'ChampionshipController@store',
            'as'   => 'championship.store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $period = new Period();

        return view('championship.create', compact('period'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChampionshipStoreRequest $request)
    {

        $season = Season::active()->first();

        if ($season !== null)
        {
            Period::create([
                'start'     => $request->start,
                'end'       => $request->end,
                'season_id' => $season->id,
                'type'      => 'championship',
            ]);

            return redirect()->route('home.index')->with('success', "Le championnat vient d'être créé !");
        }

        return redirect()->route('season.index')->with('error', "Le championnat ne peut pas être créé car il n'y a
        pas de saison active !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
