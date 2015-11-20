<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Player;

class PlayerController extends Controller
{
    public static function routes($router)
    {
        //paterns
        //$router->pattern('user_id', '[0-9]+');

        //player list
        $router->get('/index', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'PlayerController@index',
            'as'         => 'player.index',
        ]);
    }

    public function index()
    {
        $players = Player::with('user')
            ->select('players.*', 'users.*')
            ->join('users', 'users.id', '=', 'players.user_id')
            ->orderBy('users.forname', 'asc')->orderBy('users.name', 'asc')
            ->get();

        return view('player.index', compact('players'));
    }
}
