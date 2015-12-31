<?php

namespace App\Http\Controllers;

use App\Http\Requests;

/**
 * View scores
 *
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * @param $router
     */
    public static function routes($router)
    {
        //home page
        $router->get('/', [
            'uses' => 'HomeController@index',
            'as' => 'home.index',
        ]);
    }

    /**
     * View scores
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home.index');
    }
}
