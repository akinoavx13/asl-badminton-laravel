<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class CeController extends Controller
{
    public static function routes($router)
    {
        //ce home
        $router->get('/', [
            'uses' => 'CeController@index',
            'as'   => 'ce.index',
        ]);
    }

    public function index()
    {
        return view('ce.index');
    }
}
