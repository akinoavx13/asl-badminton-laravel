<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class SeasonController extends Controller
{
    public static function routes($router)
    {
        //season list
        $router->get('/index', [
            'middleware' => ['auth', 'userAdmin'],
            'uses'       => 'SeasonController@index',
            'as'         => 'season.index',
        ]);
    }

    public function index()
    {

    }
}
