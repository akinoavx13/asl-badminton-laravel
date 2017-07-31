<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdministrationController extends Controller
{

    public static function routes($router)
    {
        $router->get('index', [
            'uses' => 'AdministrationController@index',
            'as'   => 'administration.index',
        ]);
    }

    public function index()
    {
        return view('administration.index');
    }
}
