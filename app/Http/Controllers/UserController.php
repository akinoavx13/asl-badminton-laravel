<?php

namespace App\Http\Controllers;

use App\Helpers;
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
            'middleware' => ['auth', 'admin'],
            'uses'       => 'UserController@index',
            'as'         => 'user.index',
        ]);

        //users edit
        $router->get('/edit/{user_id}', [
            'middleware' => ['auth', 'userOwner'],
            'uses'       => 'UserController@edit',
            'as'         => 'user.edit',
        ]);

        //users update
        $router->post('/edit/{user_id}', [
            'middleware' => ['auth', 'userOwner'],
            'uses'       => 'UserController@update',
            'as'         => 'user.update',
        ]);

        //users delete
        $router->get('/delete/{user_id}', [
            'middleware' => ['auth', 'admin'],
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
            'middleware' => ['auth', 'admin'],
            'uses'       => 'UserController@create',
            'as'         => 'user.create',
        ]);

        //users store
        $router->post('/store', [
            'middleware' => ['auth', 'admin', 'settingExists'],
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

        //users send creation link again
        $router->get('/send_creation_link/{user_id}', [
            'middleware' => ['auth', 'admin', 'settingExists'],
            'uses'       => 'UserController@sendCreationLink',
            'as'         => 'user.send_creation_link',
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

        //si la date de fin de blessure est antèrieur à aujourd'hui
        if ($user->hasState('hurt') && Carbon::createFromFormat('d/m/Y', $request->ending_injury) <= Carbon::now())
        {
            return redirect()->back()->with('error',
                "La date de fin de blessure doit supérieur à aujourd'hui")->withInput($request->all());
        }
        elseif ($user->hasState('hurt') && Carbon::createFromFormat('d/m/Y', $request->ending_injury) > Carbon::now())
        {
            $user->update([
                'ending_injury' => $request->ending_injury,
            ]);
        }

        //si la date de fin de vacances est antèrieur à aujourd'hui
        if ($user->hasState('holiday') && Carbon::createFromFormat('d/m/Y', $request->ending_holiday) <= Carbon::now())
        {
            return redirect()->back()->with('error',
                "La date de fin de vacances doit supérieur à aujourd'hui")->withInput($request->all());
        }
        elseif ($user->hasState('holiday') && Carbon::createFromFormat('d/m/Y',
                $request->ending_holiday) > Carbon::now()
        )
        {
            $user->update([
                'ending_holiday' => $request->ending_holiday,
            ]);
        }

        if ($this->user->hasRole('admin'))
        {
            $user->update([
                'active' => $request->active,
                'role'   => $request->role,
            ]);
        }

        return redirect()->route('user.show', $user->id)->with('success',
            "Les modifications sont bien prises en compte !");
    }

    public function delete($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->back()->with('success', "L'utilisateur $user vient d'être supprimé !");
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

        if (Helpers::getInstance()->canSendMail())
        {
            Mail::send('emails.user.store', $user->attributesToArray(), function ($message) use ($user)
            {
                $message->from(Helpers::getInstance()->fromAddressMail(), Helpers::getInstance()->fromNameMail());
                $message->to($user->email, $user)
                    ->subject('Création de compte AS Lectra Badminton')->cc(Helpers::getInstance()->ccMail());
            });
        }

        return redirect()->back()->with('success', "L'utilisateur $user vient d'être crée !");
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
                'password' => bcrypt($request->password),
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
                $user->update([
                    'ending_injury' => $request->ending_injury,
                ]);
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
                $user->update([
                    'ending_holiday' => $request->ending_holiday,
                ]);
            }

            Auth::login($user);

            return redirect()->route('home.index')->with('success', "L'utilisateur $user vient d'être crée !");
        }

        abort(401, 'Unauthorized action.');
    }

    public function sendCreationLink($user_id)
    {
        $user = User::findOrFail($user_id);

        if (Helpers::getInstance()->canSendMail())
        {
            Mail::send('emails.user.store', $user->attributesToArray(), function ($message) use ($user)
            {
                $message->from(Helpers::getInstance()->fromAddressMail(), Helpers::getInstance()->fromNameMail());
                $message->to($user->email, $user)
                    ->subject('Création de compte AS Lectra Badminton')->cc(Helpers::getInstance()->ccMail());
            });
        }

        return redirect()->back()->with('success', "Un autre email vient d'être envoyé à $user !");
    }
}
