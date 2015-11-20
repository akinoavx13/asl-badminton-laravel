<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerListRequest;
use App\Player;
use App\Season;


class PlayerController extends Controller
{
    public static function routes($router)
    {
        //paterns
        $router->pattern('season_id', '[0-9]+');

        //player list
        $router->get('/index', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'PlayerController@index',
            'as'         => 'player.index',
        ]);

        //player list with season
        $router->post('/index', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'PlayerController@index',
            'as'         => 'player.index',
        ]);
    }

    public function index(PlayerListRequest $request)
    {
        $players = [];
        $season_id = null;
        if ($request->exists('season_id'))
        {
            $season_id = $request->season_id;
            $players = Player::with('user')
                ->season($season_id)
                ->select('players.*', 'users.*')
                ->join('users', 'users.id', '=', 'players.user_id')
                ->orderBy('users.forname', 'asc')
                ->orderBy('users.name', 'asc')
                ->get();
        }
        $seasons = Season::orderBy('created_at', 'desc')->lists('name', 'id');

        return view('player.index', compact('players', 'seasons', 'season_id'));
    }
}
