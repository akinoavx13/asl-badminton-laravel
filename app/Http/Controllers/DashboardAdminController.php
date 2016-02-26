<?php

namespace App\Http\Controllers;

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

        $users['nbUsersFirstConnection'] = 0;
        $users['users'] = $allUsers;
        $users['usersMan'] = [];
        $users['usersWoman'] = [];
        $users['usersLectra'] = [];
        $users['usersChild'] = [];
        $users['usersConjoint'] = [];
        $users['usersExternal'] = [];
        $users['usersTrainee'] = [];
        $users['usersSubcontractor'] = [];
        $users['usersHurt'] = [];
        $users['usersHoliday'] = [];
        $users['nbUsersInvalid'] = count($allUsers) - User::join('players', 'players.user_id', '=', 'users.id')->count();

        foreach ($allUsers as $index => $user)
        {
            if ($user->hasFirstConnection(true))
            {
                $users['nbUsersFirstConnection'] += $user;
            }

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

            if ($user->hasState('hurt'))
            {
                $users['usersHurt'][$index] = $user;
            }
            elseif ($user->hasState('holiday'))
            {
                $users['usersHoliday'][$index] = $user;
            }
        }

        return view('dashboardAdmin.index', compact('users'));
    }

}
