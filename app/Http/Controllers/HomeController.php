<?php

namespace App\Http\Controllers;

use App\Http\Requests;


class HomeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        parent::__constructor();
    }

    public static function routes($router)
    {
        $router->get('/', [
            'uses' => 'HomeController@index',
            'as' => 'home.index',
        ]);
    }

    public function index()
    {
        return view('home.index');
    }
}
