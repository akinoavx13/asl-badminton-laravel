<?php

namespace App\Http\Controllers;

use App\Court;
use App\Http\Requests\CourtStoreRequest;
use App\Http\Requests\CourtUpdateRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class CourtController extends Controller
{

    public static function routes($router)
    {
        //patterns
        $router->pattern('court_id', '[0-9]+');

        //court list
        $router->get('/index', [
            'uses' => 'CourtController@index',
            'as'   => 'court.index',
        ]);

        //court edit
        $router->get('/edit/{court_id}', [
            'uses' => 'CourtController@edit',
            'as'   => 'court.edit',
        ]);

        //court update
        $router->post('/update/{court_id}', [
            'uses' => 'CourtController@update',
            'as'   => 'court.update',
        ]);

        //court create
        $router->get('/create', [
            'uses' => 'CourtController@create',
            'as'   => 'court.create',
        ]);

        //court store
        $router->post('/store', [
            'uses' => 'CourtController@store',
            'as'   => 'court.store',
        ]);

        //court delete
        $router->get('/delete/{court_id}', [
            'uses'       => 'CourtController@delete',
            'as'         => 'court.delete',
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courts = Court::all();

        return view('court.index', compact('courts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $court = new Court();

        return view('court.create', compact('court'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourtStoreRequest $request)
    {
        $court = Court::create([
            'type'   => $request->type,
            'number' => $request->number,
        ]);

        return redirect()->route('court.index')->with('success', "Le court n° $court vient d'être créé !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($court_id)
    {
        $court = Court::findOrFail($court_id);

        return view('court.edit', compact('court'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourtUpdateRequest $request, $court_id)
    {
        $court = Court::findOrFail($court_id);

        //on ne peut pas choisir si elle est active ou pas
        $court->update([
            'type'   => $request->type,
            'number'   => $request->number,
        ]);

        return redirect()->route('court.index')->with('success', "Les modifications sont bien prises en compte !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($court_id)
    {
        $court = Court::findOrFail($court_id);
        $court->delete();

        return redirect()->route('court.index')->with('success', "Le court n° $court vient d'être supprimé !");
    }
}
