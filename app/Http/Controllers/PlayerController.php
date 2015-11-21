<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerListRequest;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Player;
use App\Season;
use DB;


class PlayerController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //paterns
        $router->pattern('player_id', '[0-9]+');

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

        //player delete
        $router->get('/delete/{player_id}', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'PlayerController@delete',
            'as'         => 'player.delete',
        ]);

        //player edit
        $router->get('/edit/{player_id}', [
            'middleware' => ['auth', 'playerOwner'],
            'uses'       => 'PlayerController@edit',
            'as'         => 'player.edit',
        ]);

        //player update
        $router->post('/edit/{player_id}', [
            'middleware' => ['auth', 'playerOwner'],
            'uses'       => 'PlayerController@update',
            'as'         => 'player.update',
        ]);

        //player create
        $router->get('/create', [
            'middleware' => 'auth',
            'uses'       => 'PlayerController@create',
            'as'         => 'player.create',
        ]);

        //player store
        $router->post('/create', [
            'middleware' => 'auth',
            'uses'       => 'PlayerController@store',
            'as'         => 'player.store',
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
                ->select('players.*')
                ->season($season_id)
                ->join('users', 'users.id', '=', 'players.user_id')
                ->orderBy('users.forname', 'asc')
                ->orderBy('users.name', 'asc')
                ->get();
        }
        $seasons = Season::orderBy('created_at', 'desc')->lists('name', 'id');

        return view('player.index', compact('players', 'seasons', 'season_id'));
    }

    public function delete($player_id)
    {
        $player = Player::findOrFail($player_id);
        $player->delete();

        flash()->success('Supprimé !', '');

        return redirect()->back();
    }

    public function edit($player_id)
    {
        $player = Player::findOrFail($player_id);

        return view('player.edit', compact('player'));
    }

    public function update(PlayerUpdateRequest $request, $player_id)
    {
        $player = Player::findOrFail($player_id);

        if ($this->user->hasRole('admin'))
        {
            $player->update([
                'ce_state'  => $request->ce_state,
                'gbc_state' => $request->gbc_state,
            ]);
        }

        $player->update([
            'formula'     => $request->formula,
            't_shirt'     => $request->formula === 'leisure' || $request->formula === 'fun' || $request->formula === 'performance' ? $request->t_shirt : true,
            'simple'      => $request->formula !== 'leisure' ? $request->simple : false,
            'double'      => $request->formula !== 'leisure' ? $request->double : false,
            'mixte'       => $request->formula !== 'leisure' ? $request->mixte : false,
            'corpo_man'   => ($request->formula === 'corpo' || $request->formula === 'competition') && $player->user->hasGender('man') ? $request->corpo_man : false,
            'corpo_woman' => ($request->formula === 'corpo' || $request->formula === 'competition') && $player->user->hasGender('woman') ? $request->corpo_woman : false,
            'corpo_mixte' => $request->formula === 'corpo' || $request->formula === 'competition' ? $request->corpo_mixte : false,
        ]);

        flash()->success('Sauvegardée !', '');

        return redirect()->route('home.index');
    }

    public function create()
    {
        $player = new Player();

        $seasons = Season::active()->lists('name', 'id');

        return view('player.create', compact('player', 'seasons'));
    }

    public function store(PlayerStoreRequest $request)
    {

        $numberOfPlayerForUserInSelectedSeason = Player::select('players.*')
            ->season($request->season_id)
            ->where('user_id', $this->user->id)
            ->count();

        if ($numberOfPlayerForUserInSelectedSeason >= 1)
        {
            return redirect()->back()->with('error',
                "Vous êtes est déjà inscrit dans cette saison.")->withInput($request->input());
        }

        $player = Player::create([
            'formula'     => $request->formula,
            't_shirt'     => $request->formula === 'leisure' || $request->formula === 'fun' || $request->formula === 'performance' ? $request->t_shirt : true,
            'simple'      => $request->formula !== 'leisure' ? $request->simple : false,
            'double'      => $request->formula !== 'leisure' ? $request->double : false,
            'mixte'       => $request->formula !== 'leisure' ? $request->mixte : false,
            'corpo_man'   => ($request->formula === 'corpo' || $request->formula === 'competition') && $this->user->hasGender('man') ? $request->corpo_man : false,
            'corpo_woman' => ($request->formula === 'corpo' || $request->formula === 'competition') && $this->user->hasGender('woman') ? $request->corpo_woman : false,
            'corpo_mixte' => $request->formula === 'corpo' || $request->formula === 'competition' ? $request->corpo_mixte : false,
            'user_id'     => $this->user->id,
            'ce_state'    => $this->user->hasRole('admin') ? $request->ce_state : 'contribution_payable',
            'gbc_state'   => $this->onPlayerCreateChoseGbc_state($request),
        ]);

        DB::table('player_season')->insert([
            'player_id' => $player->id,
            'season_id' => $request->season_id,
        ]);

        flash()->success('Créée !', '');

        return redirect()->route('home.index');
    }

    private function onPlayerCreateChoseGbc_state($request)
    {
        if ($this->user->hasRole('admin'))
        {
            return $request->gbc_state;
        }
        else
        {
            if ($request->formula === 'leisure' || $request->formula === 'fun' || $request->formula === 'performance')
            {
                return 'non_applicable';
            }
            elseif ($request->formula === 'corpo' || $request->formula === 'competition')
            {
                return 'entry_must';
            }
        }

        return 'non_applicable';
    }
}
