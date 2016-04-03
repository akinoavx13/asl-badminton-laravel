<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Tournament;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public static function routes($router)
    {

        $router->get('create', [
            'middleware' => 'admin',
            'uses'       => 'SeriesController@create',
            'as'         => 'series.create',
        ]);

        $router->post('create', [
            'middleware' => 'admin',
            'uses'       => 'SeriesController@store',
            'as'         => 'series.store',
        ]);
    }

    public function create()
    {
        $tournament = Tournament::lasted()->first();
        
        if ($tournament != null)
        {
            return view('series.create', compact('tournament'));
        }

        return redirect()->back()->with('error', 'Il faut une saison active !');

    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
