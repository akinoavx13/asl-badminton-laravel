<?php

namespace App\Http\Controllers;

use App\Actuality;
use App\Http\Requests;
use App\Http\Utilities\SendMail;
use App\Post;
use App\Score;
use Jenssegers\Date\Date;

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

        $actus = Actuality::select('users.name', 'users.forname', 'users.avatar',
            'actualities.title', 'actualities.content', 'actualities.photo', 'actualities.user_id',
            'actualities.created_at', 'actualities.id')
            ->join('users', 'users.id', '=', 'actualities.user_id')
            ->orderBy('actualities.created_at', 'desc')
            ->take(15)
            ->get();

        $posts = Post::select('users.name', 'users.forname', 'users.avatar', 'posts.content', 'posts.user_id',
            'posts.photo', 'posts.created_at', 'posts.actuality_id', 'posts.id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->whereNotNull('posts.actuality_id')
            ->whereNull('posts.score_id')
            ->orderBy('posts.created_at', 'asc')
            ->get();

        $actualities = [];

        foreach ($actus as $index => $actuality)
        {
            $actualities[$index]['userName'] = $actuality->forname . ' ' . $actuality->name;
            $actualities[$index]['userAvatar'] = $actuality->avatar ? "/img/avatars/{$actuality->user_id}.jpg" :
                'img/anonymous.png';
            $actualities[$index]['userId'] = $actuality->user_id;
            $actualities[$index]['title'] = $actuality->title;
            $actualities[$index]['content'] = $actuality->content;
            $actualities[$index]['photo'] = $actuality->photo;
            $actualities[$index]['createdAt'] = ucfirst(Date::create($actuality->created_at->year,
                $actuality->created_at->month,
                $actuality->created_at->day, $actuality->created_at->hour, $actuality->created_at->minute,
                $actuality->created_at->second)->ago());
            $actualities[$index]['actualityId'] = $actuality->id;
            $actualities[$index]['posts'] = null;

            foreach ($posts as $indexPost => $post)
            {
                if ($post->actuality_id == $actuality->id)
                {
                    $actualities[$index]['posts'][$indexPost]['postId'] = $post->id;
                    $actualities[$index]['posts'][$indexPost]['userId'] = $post->user_id;
                    $actualities[$index]['posts'][$indexPost]['userName'] = $post->forname . ' ' . $post->name;
                    $actualities[$index]['posts'][$indexPost]['userAvatar'] = $post->avatar ?
                        "/img/avatars/{$post->user_id}.jpg" :
                        'img/anonymous.png';
                    $actualities[$index]['posts'][$indexPost]['content'] = $post->content;
                    $actualities[$index]['posts'][$indexPost]['photo'] = $post->photo;
                    $actualities[$index]['posts'][$indexPost]['createdAt'] = ucfirst(Date::create($post->created_at->year,
                        $post->created_at->month,
                        $post->created_at->day, $post->created_at->hour, $post->created_at->minute,
                        $post->created_at->second)->ago());
                }
            }
        }

        return view('home.index', compact('scores', 'actualities'));
    }
}
