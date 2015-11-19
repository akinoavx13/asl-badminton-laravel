<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //paterns
        $router->pattern('user_id', '[0-9]+');

        //user list
        $router->get('/index', [
            'middleware' => 'userAdmin',
            'uses' => 'UserController@index',
            'as'   => 'user.index',
        ]);

        //users edit
        $router->get('/edit/{user_id}', [
            'middleware' => 'owner',
            'uses'       => 'UserController@edit',
            'as'         => 'user.edit',
        ]);

        //users update
        $router->post('/edit/{user_id}', [
            'middleware' => 'owner',
            'uses'       => 'UserController@update',
            'as'         => 'user.update',
        ]);

        //users delete
        $router->get('/delete/{user_id}', [
            'middleware' => 'userAdmin',
            'uses'       => 'UserController@delete',
            'as'         => 'user.delete',
        ]);

        //users show
        $router->get('/show/{user_id}', [
            'middleware' => 'auth',
            'uses'       => 'UserController@show',
            'as'         => 'user.show',
        ]);

    }

    public function index()
    {
        $users = User::orderBy('forname', 'asc')->get();

        return view('users.index', compact('users'));
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $user->update([
            'name'                => $request->name,
            'forname'             => $request->forname,
            'birthday'            => $request->birthday,
            'tshirt_size'         => $request->tshirt_size,
            'gender'              => $request->gender,
            'address'  => $request->address !== "" ? $request->address : null,
            'phone'    => $request->phone !== "" ? $request->phone : null,
            'license'  => $request->license !== "" ? $request->license : null,
            'state'               => $request->state,
            'lectra_relationship' => $request->lectra_relationship,
            'newsletter'          => $request->newsletter,
            'password' => $request->password !== "" ? bcrypt($request->password) : $user->password,
            'avatar'   => $request->avatar,
        ]);

        if ($user->hasState('hurt') && Carbon::createFromFormat('d/m/Y', $request->ending_injury) <= Carbon::now())
        {
            return redirect()->back()->with('error',
                "La date de fin de blessure doit supérieur à aujourd'hui")->withInput($request->all());
        }
        elseif ($user->hasState('hurt') && Carbon::createFromFormat('d/m/Y', $request->ending_injury) > Carbon::now())
        {
            $user->ending_injury = $request->ending_injury;
            $user->save();
        }

        if ($user->hasState('holiday') && Carbon::createFromFormat('d/m/Y', $request->ending_holiday) <= Carbon::now())
        {
            return redirect()->back()->with('error',
                "La date de fin de vacances doit supérieur à aujourd'hui")->withInput($request->all());
        }
        elseif ($user->hasState('holiday') && Carbon::createFromFormat('d/m/Y',
                $request->ending_holiday) > Carbon::now()
        )
        {
            $user->ending_holiday = $request->ending_holiday;
            $user->save();
        }

        if ($this->user->hasRole('admin'))
        {
            $user->active = $request->active;
            $user->role = $request->role;
            $user->save();
        }

        flash()->success('Sauvegarde !', '');

        return redirect()->route('home.index');
    }

    public function delete($user_id)
    {

        $user = User::findOrFail($user_id);
        $user->delete();

        flash()->success('Supprimer !', '');

        return redirect()->back();
    }

    public function show($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('users.show', compact('user'));
    }
}
