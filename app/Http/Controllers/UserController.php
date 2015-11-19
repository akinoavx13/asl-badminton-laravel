<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserFirstConnectionRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Auth;
use Carbon\Carbon;
use Mail;

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
            'middleware' => ['auth', 'userAdmin'],
            'uses'       => 'UserController@index',
            'as'         => 'user.index',
        ]);

        //users edit
        $router->get('/edit/{user_id}', [
            'middleware' => ['auth', 'owner'],
            'uses'       => 'UserController@edit',
            'as'         => 'user.edit',
        ]);

        //users update
        $router->post('/edit/{user_id}', [
            'middleware' => ['auth', 'owner'],
            'uses'       => 'UserController@update',
            'as'         => 'user.update',
        ]);

        //users delete
        $router->get('/delete/{user_id}', [
            'middleware' => ['auth', 'userAdmin'],
            'uses'       => 'UserController@delete',
            'as'         => 'user.delete',
        ]);

        //users show
        $router->get('/show/{user_id}', [
            'middleware' => 'auth',
            'uses'       => 'UserController@show',
            'as'         => 'user.show',
        ]);

        //users create
        $router->get('/create', [
            'middleware' => ['auth', 'userAdmin'],
            'uses'       => 'UserController@create',
            'as'         => 'user.create',
        ]);

        //users store
        $router->post('/store', [
            'middleware' => ['auth', 'userAdmin'],
            'uses'       => 'UserController@store',
            'as'         => 'user.store',
        ]);

        //users first connection
        $router->get('/first_connection/{user_id}/{token_first_connection}', [
            'middleware' => 'firstConnection',
            'uses'       => 'UserController@getFirstConnection',
            'as'         => 'user.get_first_connection',
        ]);

        //users first connection
        $router->post('/first_connection/{user_id}/{token_first_connection}', [
            'middleware' => 'firstConnection',
            'uses'       => 'UserController@postFirstConnection',
            'as'         => 'user.post_first_connection',
        ]);

    }

    public function index()
    {
        $users = User::orderBy('forname', 'asc')->get();

        return view('user.index', compact('users'));
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('user.edit', compact('user'));
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

        return view('user.show', compact('user'));
    }

    public function create()
    {
        $user = new User();

        return view('user.create', compact('user'));
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create([
            'name'                   => $request->name,
            'forname'                => $request->forname,
            'email'                  => $request->email,
            'role'                   => $request->role,
            'active'                 => $request->active,
            'token_first_connection' => str_random(60),
            'ending_injury'  => Carbon::now()->format('d/m/Y'),
            'ending_holiday' => Carbon::now()->format('d/m/Y'),
        ]);

        if (canSendMail())
        {
            Mail::send('emails.user.store', $user->attributesToArray(), function ($message) use ($user)
            {
                $message->from(fromAddressMail(), fromNameMail());
                $message->to($user->email, $user)
                    ->subject('Création de compte AS Lectra Badminton')->cc('c.maheo@lectra.com');
            });
        }

        flash()->success('Cree !', 'Un email lui a ete envoye.');

        return redirect()->route('home.index');
    }

    public function getFirstConnection($user_id, $token_first_connection)
    {
        $user = User::where('id', $user_id)->where('token_first_connection', $token_first_connection)->first();

        if ($user !== null)
        {
            return view('user.first_connection', compact('user'));
        }

        abort(401, 'Unauthorized action.');
    }

    public function postFirstConnection(UserFirstConnectionRequest $request, $user_id, $token_first_connection)
    {
        $user = User::where('id', $user_id)->where('token_first_connection', $token_first_connection)->first();

        if ($user !== null)
        {
            $user->update([
                'name'                => $request->name,
                'forname'             => $request->forname,
                'birthday'            => $request->birthday,
                'tshirt_size'         => $request->tshirt_size,
                'gender'              => $request->gender,
                'address'             => $request->address !== "" ? $request->address : null,
                'phone'               => $request->phone !== "" ? $request->phone : null,
                'license'             => $request->license !== "" ? $request->license : null,
                'state'               => $request->state,
                'lectra_relationship' => $request->lectra_relationship,
                'newsletter'          => $request->newsletter,
                'password'            => $request->password,
                'avatar'              => $request->avatar,
                'first_connect'       => false,
            ]);

            if ($user->hasState('hurt') && Carbon::createFromFormat('d/m/Y', $request->ending_injury) <= Carbon::now())
            {
                return redirect()->back()->with('error',
                    "La date de fin de blessure doit supérieur à aujourd'hui")->withInput($request->all());
            }
            elseif ($user->hasState('hurt') && Carbon::createFromFormat('d/m/Y',
                    $request->ending_injury) > Carbon::now()
            )
            {
                $user->ending_injury = $request->ending_injury;
                $user->save();
            }

            if ($user->hasState('holiday') && Carbon::createFromFormat('d/m/Y',
                    $request->ending_holiday) <= Carbon::now()
            )
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

            Auth::login($user);

            flash()->success('Compte valide !', "Le compte viens d etre creer avec sucess");

            return redirect()->route('home.index');
        }

        abort(401, 'Unauthorized action.');
    }
}
