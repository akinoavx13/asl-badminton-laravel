<?php

namespace App\Http\Controllers;

use App\Player;
use App\Season;
use App\Team;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardAdminController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {

        $router->get('/index', [
            'uses' => 'DashboardAdminController@index',
            'as'   => 'dashboardAdmin.index',
        ]);

    }

    public function index()
    {

        $allUsers = User::all();

        $users['nbUsersFirstConnection'] = User::where('first_connect', 1)
            ->orderByForname()
            ->get();
        $users['users'] = $allUsers;
        $users['usersMan'] = [];
        $users['usersWoman'] = [];
        $users['usersLectra'] = [];
        $users['usersChild'] = [];
        $users['usersConjoint'] = [];
        $users['usersExternal'] = [];
        $users['usersTrainee'] = [];
        $users['usersSubcontractor'] = [];
        $users['usersPartnership'] = [];
        $users['usersHurt'] = [];
        $users['usersHoliday'] = [];
        $users['nbUsersInvalid'] =
        $users['nbUsersNonInscrit'] = User::leftJoin('players', 'players.user_id', '=', 'users.id')
            ->whereNull('players.id')
            ->get();

        $players = [];

        foreach ($allUsers as $index => $user)
        {
            if ($user->hasGender('man'))
            {
                $users['usersMan'][$index] = $user;
            }
            else
            {
                $users['usersWoman'][$index] = $user;
            }

            if ($user->hasLectraRelation('lectra'))
            {
                $users['usersLectra'][$index] = $user;
            }
            elseif ($user->hasLectraRelation('child'))
            {
                $users['usersChild'][$index] = $user;
            }
            elseif ($user->hasLectraRelation('conjoint'))
            {
                $users['usersConjoint'][$index] = $user;
            }
            elseif ($user->hasLectraRelation('external'))
            {
                $users['usersExternal'][$index] = $user;
            }
            elseif ($user->hasLectraRelation('trainee'))
            {
                $users['usersTrainee'][$index] = $user;
            }
            elseif ($user->hasLectraRelation('subcontractor'))
            {
                $users['usersSubcontractor'][$index] = $user;
            }
            elseif ($user->hasLectraRelation('partnership'))
            {
                $users['usersPartnership'][$index] = $user;
            }

            if ($user->hasState('hurt'))
            {
                $users['usersHurt'][$index] = $user;
            }
            elseif ($user->hasState('holiday'))
            {
                $users['usersHoliday'][$index] = $user;
            }
        }

        $activeSeason = Season::active()->first();
        if ($activeSeason != null)
        {
            $allPlayers = Player::select('players.*', 'users.email', 'users.gender', 'users.tshirt_size',
                'users.avatar', 'users.id as user_id')
                ->join('users', 'users.id', '=', 'players.user_id')
                ->with('user')
                ->where('season_id', $activeSeason->id)
                ->orderByForname()
                ->get();

            $players['players'] = $allPlayers;
            $players['contribution_payable'] = [];
            $players['entry_must'] = [];
            $players['t_shirt'] = [];
            $players['t_shirt_man'] = [];
            $players['t_shirt_man_xxs'] = [];
            $players['t_shirt_man_xs'] = [];
            $players['t_shirt_man_s'] = [];
            $players['t_shirt_man_m'] = [];
            $players['t_shirt_man_l'] = [];
            $players['t_shirt_man_xl'] = [];
            $players['t_shirt_man_xxl'] = [];

            $players['t_shirt_woman'] = [];
            $players['t_shirt_woman_xxs'] = [];
            $players['t_shirt_woman_xs'] = [];
            $players['t_shirt_woman_s'] = [];
            $players['t_shirt_woman_m'] = [];
            $players['t_shirt_woman_l'] = [];
            $players['t_shirt_woman_xl'] = [];
            $players['t_shirt_woman_xxl'] = [];

            $players['t_shirt_corpo_competition'] = [];
            $players['t_shirt_buy'] = [];

            $players['leisure'] = [];
            $players['tournament'] = [];
            $players['fun'] = [];
            $players['performance'] = [];
            $players['corpo'] = [];
            $players['competition'] = [];
            $players['corpo_man'] = [];
            $players['corpo_woman'] = [];
            $players['corpo_mixte'] = [];

            $players['simple'] = [];
            $players['double'] = Team::select(
                'userOne.avatar as userOneAvatar',
                'userOne.id as userOneId',
                'userOne.name as userOneName',
                'userOne.forname as userOneForname',

                'userTwo.avatar as userTwoAvatar',
                'userTwo.id as userTwoId',
                'userTwo.name as userTwoName',
                'userTwo.forname as userTwoForname')
                ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                ->where('teams.season_id', $activeSeason->id)
                ->where('teams.enable', true)
                ->where('teams.double_man', true)
                ->orWhere(function ($query) use ($activeSeason)
                {
                    $query->where('teams.season_id', $activeSeason->id)
                        ->where('teams.enable', true)
                        ->where('teams.double_woman', true);
                })
                ->orderBy('userOne.forname')
                ->orderBy('userTwo.forname')
                ->get();

            $players['mixte'] = Team::select('userOne.avatar as userOneAvatar',
                'userOne.id as userOneId',
                'userOne.name as userOneName',
                'userOne.forname as userOneForname',

                'userTwo.avatar as userTwoAvatar',
                'userTwo.id as userTwoId',
                'userTwo.name as userTwoName',
                'userTwo.forname as userTwoForname')
                ->join('players as playerOne', 'playerOne.id', '=', 'teams.player_one')
                ->join('players as playerTwo', 'playerTwo.id', '=', 'teams.player_two')
                ->join('users as userOne', 'userOne.id', '=', 'playerOne.user_id')
                ->join('users as userTwo', 'userTwo.id', '=', 'playerTwo.user_id')
                ->where('teams.season_id', $activeSeason->id)
                ->where('teams.enable', true)
                ->where('teams.mixte', true)
                ->orderBy('userOne.forname')
                ->orderBy('userTwo.forname')
                ->get();

            $players['search_double'] = [];
            $players['search_mixte'] = [];

            foreach ($allPlayers as $index => $player)
            {

                if ($player->hasSimple(true))
                {
                    $players['simple'][$index] = $player;
                }

                if ($player->search_double)
                {
                    $players['search_double'][$index] = $player;
                }
                if ($player->search_mixte)
                {
                    $players['search_mixte'][$index] = $player;
                }

                if ($player->hasCeState('contribution_payable'))
                {
                    $players['contribution_payable'][$index] = $player;
                }

                if ($player->hasGbcState('entry_must'))
                {
                    $players['entry_must'][$index] = $player;
                }

                if ($player->hasTShirt(true))
                {
                    $players['t_shirt'][$index] = $player;

                    if ($player->formula == 'corpo' || $player->formula == 'competition')
                    {
                        $players['t_shirt_corpo_competition'][$index] = $player;
                    }
                    else
                    {
                        $players['t_shirt_buy'][$index] = $player;
                    }

                    if ($player->gender == 'man')
                    {
                        $players['t_shirt_man'][$index] = $player;
                        if ($player->tshirt_size == 'XXS')
                        {
                            $players['t_shirt_man_xxs'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'XS')
                        {
                            $players['t_shirt_man_xs'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'S')
                        {
                            $players['t_shirt_man_s'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'M')
                        {
                            $players['t_shirt_man_m'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'L')
                        {
                            $players['t_shirt_man_l'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'XL')
                        {
                            $players['t_shirt_man_xl'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'XXL')
                        {
                            $players['t_shirt_man_xxl'][$index] = $player;
                        }
                    }
                    else
                    {
                        $players['t_shirt_woman'][$index] = $player;

                        if ($player->tshirt_size == 'XXS')
                        {
                            $players['t_shirt_woman_xxs'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'XS')
                        {
                            $players['t_shirt_woman_xs'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'S')
                        {
                            $players['t_shirt_woman_s'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'M')
                        {
                            $players['t_shirt_woman_m'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'L')
                        {
                            $players['t_shirt_woman_l'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'XL')
                        {
                            $players['t_shirt_woman_xl'][$index] = $player;
                        }
                        elseif ($player->tshirt_size == 'XXL')
                        {
                            $players['t_shirt_woman_xxl'][$index] = $player;
                        }
                    }
                }

                if ($player->hasFormula('leisure'))
                {
                    $players['leisure'][$index] = $player;
                }

                if ($player->hasFormula('tournament'))
                {
                    $players['tournament'][$index] = $player;
                }

                if ($player->hasFormula('fun'))
                {
                    $players['fun'][$index] = $player;
                }

                if ($player->hasFormula('performance'))
                {
                    $players['performance'][$index] = $player;
                }

                if ($player->hasFormula('corpo'))
                {
                    $players['corpo'][$index] = $player;
                }

                if ($player->hasFormula('competition'))
                {
                    $players['competition'][$index] = $player;
                }

                if ($player->hasCorpoMan(true))
                {
                    $players['corpo_man'][$index] = $player;
                }

                if ($player->hasCorpoWoman(true))
                {
                    $players['corpo_woman'][$index] = $player;
                }

                if ($player->hasCorpoMixte(true))
                {
                    $players['corpo_mixte'][$index] = $player;
                }
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Il n\'y a pas de saison active !');
        }


        return view('dashboardAdmin.index', compact('users', 'players', 'activeSeason'));
    }

}
