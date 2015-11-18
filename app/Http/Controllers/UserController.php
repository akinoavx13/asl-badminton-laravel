<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{

    public static function routes($router)
    {
        //users index
        $router->get('/index', [
            'middleware' => 'userAdmin',
            'uses' => 'UserController@index',
            'as' => 'user.index',
        ]);
    }

    public function index()
    {

        $users = User::orderBy('forname', 'asc')->get();

        return view('users.index', compact('users'));
    }
}
