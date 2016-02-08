<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Utilities\SendMail;
use App\Score;

/**
 * View scores
 *
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    /**
     * @param $router
     */
    public static function routes($router)
    {
        //home page
        $router->get('/', [
            'uses' => 'HomeController@index',
            'as'   => 'home.index',
        ]);
    }

    /**
     * View scores
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        SendMail::send($this->user, 'test', [], 'toto');

        $scores = Score::select(
            'userOneTeamOne.name as userOneTeamOne_name',
            'userOneTeamOne.forname as userOneTeamOne_forname',

            'userTwoTeamOne.name as userTwoTeamOne_name',
            'userTwoTeamOne.forname as userTwoTeamOne_forname',

            'userOneTeamTwo.name as userOneTeamTwo_name',
            'userOneTeamTwo.forname as userOneTeamTwo_forname',

            'userTwoTeamTwo.name as userTwoTeamTwo_name',
            'userTwoTeamTwo.forname as userTwoTeamTwo_forname',

            'scores.my_wo', 'scores.his_wo', 'scores.unplayed',

            'scores.first_set_first_team', 'scores.first_set_second_team',
            'scores.second_set_first_team', 'scores.second_set_second_team',
            'scores.third_set_first_team', 'scores.third_set_second_team',
            'scores.first_team_win', 'scores.second_team_win', 'scores.updated_at'
        )
            ->leftJoin('teams as teamOne', 'teamOne.id', '=', 'scores.first_team_id')
            ->leftJoin('players as playerOneTeamOne', 'playerOneTeamOne.id', '=', 'teamOne.player_one')
            ->leftJoin('players as playerTwoTeamOne', 'playerTwoTeamOne.id', '=', 'teamOne.player_two')
            ->leftJoin('users as userOneTeamOne', 'userOneTeamOne.id', '=', 'playerOneTeamOne.user_id')
            ->leftJoin('users as userTwoTeamOne', 'userTwoTeamOne.id', '=', 'playerTwoTeamOne.user_id')
            ->leftJoin('teams as teamTwo', 'teamTwo.id', '=', 'scores.second_team_id')
            ->leftJoin('players as playerOneTeamTwo', 'playerOneTeamTwo.id', '=', 'teamTwo.player_one')
            ->leftJoin('players as playerTwoTeamTwo', 'playerTwoTeamTwo.id', '=', 'teamTwo.player_two')
            ->leftJoin('users as userOneTeamTwo', 'userOneTeamTwo.id', '=', 'playerOneTeamTwo.user_id')
            ->leftJoin('users as userTwoTeamTwo', 'userTwoTeamTwo.id', '=', 'playerTwoTeamTwo.user_id')
            ->where('scores.display', true)
            ->orderBy('scores.updated_at', 'desc')
            ->paginate(15);

        return view('home.index', compact('scores'));
    }
}
