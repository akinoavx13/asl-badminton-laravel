<?php

namespace App\Http\Controllers;

use App\Http\Requests;


class HomeController extends Controller
{

    public static function routes($router)
    {
        //home page
        $router->get('/', [
            'middleware' => 'auth',
            'uses' => 'HomeController@index',
            'as' => 'home.index',
        ]);
    }

    public function index()
    {
        return view('home.index');
    }
}
