<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserFirstConnectionRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Utilities\SendMail;
use App\Player;
use App\Season;
use App\User;
use Auth;
use Carbon\Carbon;
use Mail;

/**
 * Manage users
 *
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__constructor();
    }

    /**
     * @param $router
     */
    public static function routes($router)
    {
        //pattern
        $router->pattern('user_id', '[0-9]+');

        //user list
        $router->get('/index', [
            'middleware' => ['admin'],
            'uses'       => 'UserController@index',
            'as'         => 'user.index',
        ]);

        //users edit
        $router->get('/edit/{user_id}', [
            'middleware' => ['userOwner'],
            'uses'       => 'UserController@edit',
            'as'         => 'user.edit',
        ]);

        //users update
        $router->post('/edit/{user_id}', [
            'middleware' => ['userOwner'],
            'uses'       => 'UserController@update',
            'as'         => 'user.update',
        ]);

        //users delete
        $router->get('/delete/{user_id}', [
            'middleware' => ['admin'],
            'uses'       => 'UserController@delete',
            'as'         => 'user.delete',
        ]);

        //users show
        $router->get('/show/{user_id}', [
            'uses' => 'UserController@show',
            'as'   => 'user.show',
        ]);

        //users create
        $router->get('/create', [
            'middleware' => ['admin'],
            'uses'       => 'UserController@create',
            'as'         => 'user.create',
        ]);

        //users store
        $router->post('/store', [
            'middleware' => ['admin', 'settingExists'],
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
            'middleware' => ['admin', 'settingExists'],
            'uses'       => 'UserController@sendCreationLink',
            'as'         => 'user.send_creation_link',
        ]);

        //users create
        $router->get('/changePassword/{user_id}', [
            'middleware' => ['userOwner'],
            'uses'       => 'UserController@changePassword',
            'as'         => 'user.changePassword',
        ]);

        //users store
        $router->post('/changePassword/{user_id}', [
            //'middleware' => ['userOwner'],
            'uses'       => 'UserController@updatePassword',
            'as'         => 'user.updatePassword',
        ]);

    }

    /**
     * View all users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::OrderByForname()->get();

        return view('user.index', compact('users'));
    }

    /**
     * Form to create user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = new User();

        return view('user.create', compact('user'));
    }

    /**
     * Store the user created
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create([
            'name'                   => $request->name,
            'forname'                => $request->forname,
            'email'                  => $request->email,
            'role'                   => $request->role,
            'active'                 => $request->active,
            'token_first_connection' => str_random(60),
            'ending_injury'          => Carbon::now()->format('d/m/Y'),
            'ending_holiday'         => Carbon::now()->format('d/m/Y'),
        ]);

        SendMail::send($this->user, 'newUser', $user->attributesToArray(), 'Création de compte AS Lectra Badminton');

        return redirect()->back()->with('success', "L'utilisateur $user vient d'être crée !");
    }

    /**
     * Show the profile of the user, also the players profile
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);

        $activeSeason = Season::active()->first();

        $player = null;

        if ($activeSeason !== null)
        {
            $player = Player::withUser($user_id)->withSeason($activeSeason->id)->first();
        }

        return view('user.show', compact('user', 'player'));
    }

    /**
     * Form to update user
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the user edited
     *
     * @param UserUpdateRequest $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $data['oldValues'] = $user->attributesToArray();

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
            'avatar'              => $request->avatar,
        ]);

        $this->updateIfInjuryHolidayAreAfterNow($user, $request);

        if ($this->user->hasRole('admin'))
        {
            $user->update([
                'active' => $request->active,
                'role'   => $request->role,
            ]);
        }

        $admin = User::where('email', 'c.maheo@lectra.com')->first();

        if ($admin != null)
        {
            $data['newValues'] = $user->attributesToArray();
            $data['userName'] = $user->forname . " " . $user->name;
            $data['adminUserName'] = $admin->forname . " " . $admin->name;

            SendMail::send($admin, 'updateProfil', $data, 'Modification d\'un profil AS Lectra Badminton');
        }

        return redirect()->route('user.show', $user->id)->with('success',
            "Les modifications sont bien prises en compte !");
    }

    /**
     * Delete the selected user
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->back()->with('success', "L'utilisateur $user vient d'être supprimé !");
    }

    /**
     * Helpfull to determined the date of his holiday or his injury
     * Check if the date chosen is after today
     *
     * @param $user
     * @param $request
     * @return $this
     */
    private function updateIfInjuryHolidayAreAfterNow($user, $request)
    {
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
    }

    /**
     * Return the view to fill his informations because is the first time is conects
     *
     * @param $user_id
     * @param $token_first_connection
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFirstConnection($user_id, $token_first_connection)
    {
        $user = User::where('id', $user_id)
            ->where('token_first_connection', $token_first_connection)
            ->first();

        if ($user !== null)
        {
            return view('user.first_connection', compact('user'));
        }

        abort(401, 'Unauthorized action.');
    }

    /**
     * Update informations of the early connected user
     *
     * @param UserFirstConnectionRequest $request
     * @param $user_id
     * @param $token_first_connection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFirstConnection(UserFirstConnectionRequest $request, $user_id, $token_first_connection)
    {
        $user = User::where('id', $user_id)
            ->where('token_first_connection', $token_first_connection)
            ->first();

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
                'password'            => bcrypt($request->password),
                'avatar'              => $request->avatar,
                'first_connect'       => false,
            ]);

            $this->updateIfInjuryHolidayAreAfterNow($user, $request);

            Auth::login($user);

            return redirect()->route('home.index')->with('success', "L'utilisateur $user vient d'être crée !");
        }

        abort(401, 'Unauthorized action.');
    }

    /**
     * Send the creation link again
     *
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendCreationLink($user_id)
    {
        $user = User::findOrFail($user_id);

        SendMail::send($this->user, 'newUser', $user->attributesToArray(), 'Création de compte AS Lectra Badminton');

        return redirect()->back()->with('success', "Un autre email vient d'être envoyé à $user !");
    }

    public function changePassword($user_id)
    {
        return view('user.changePassword', compact('user_id'));
    }

    public function updatePassword(UserChangePasswordRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.show', $user_id)->with('success', "Le mot de passe a bien été changé !");

    }
}


