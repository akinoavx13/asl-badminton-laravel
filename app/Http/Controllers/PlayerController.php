<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerListRequest;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Player;
use App\Season;
use App\Setting;


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
            'middleware' => ['admin'],
            'uses'       => 'PlayerController@index',
            'as'         => 'player.index',
        ]);

        //player list with season
        $router->post('/index', [
            'middleware' => ['admin'],
            'uses'       => 'PlayerController@index',
            'as'         => 'player.index',
        ]);

        //player delete
        $router->get('/delete/{player_id}', [
            'middleware' => ['admin'],
            'uses'       => 'PlayerController@delete',
            'as'         => 'player.delete',
        ]);

        //player edit
        $router->get('/edit/{player_id}', [
            'middleware' => ['playerOwner'],
            'uses'       => 'PlayerController@edit',
            'as'         => 'player.edit',
        ]);

        //player update
        $router->post('/edit/{player_id}', [
            'middleware' => ['playerOwner', 'buyTshirtClose'],
            'uses'       => 'PlayerController@update',
            'as'         => 'player.update',
        ]);

        //player create
        $router->get('/create', [
            'middleware' => ['enrollOpen'],
            'uses'       => 'PlayerController@create',
            'as'         => 'player.create',
        ]);

        //player store
        $router->post('/create', [
            'middleware' => ['enrollOpen', 'buyTshirtClose'],
            'uses'       => 'PlayerController@store',
            'as'         => 'player.store',
        ]);

        //player change ce_state to contribution_paid
        $router->get('/ce_state/contribution_paid/{player_id}', [
            'middleware' => ['admin'],
            'uses'       => 'PlayerController@changeCeStateToContributionPaid',
            'as'         => 'player.ce_stateTocontribution_paid',
        ]);

        //player change gbc_state to valid
        $router->get('/gbc_state/valid/{player_id}', [
            'middleware' => ['admin'],
            'uses'       => 'PlayerController@changeGbcStateToValid',
            'as'         => 'player.gbc_stateTocontribution_paid',
        ]);
    }

    public function index(PlayerListRequest $request)
    {
        $season = null;
        $players = [];

        //si on a choisit une saison
        if ($request->exists('season_id'))
        {
            $season = Season::findOrFail($request->season_id);

            $season_id = $season !== null ? $season->id : null;

            $players = Player::orderByForname()
                ->select('players.*')
                ->withSeason($season_id)
                ->get();
        }
        //on a par default la saison active
        else
        {
            $season = Season::active()->first();

            $season_id = $season !== null ? $season->id : null;

            $players = Player::orderByForname()
                ->select('players.*')
                ->withSeason($season_id)
                ->get();
        }
        $seasons = Season::orderBy('created_at', 'desc')->lists('name', 'id');

        return view('player.index', compact('players', 'seasons', 'season'));
    }

    public function delete($player_id)
    {
        $player = Player::findOrFail($player_id);
        $player->delete();

        return redirect()->route('player.index')->with('success', "Le joueur $player a été supprimé !");
    }

    public function edit($player_id)
    {
        $player = Player::findOrFail($player_id);
        $setting = Setting::first();

        return view('player.edit', compact('player', 'setting'));
    }

    public function update(PlayerUpdateRequest $request, $player_id)
    {
        $player = Player::findOrFail($player_id);

        //si on est admin on peut mettre à jour les 2 champs
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

        return redirect()->route('home.index')->with('success', "Les modifications sont bien prise en compte !");
    }

    public function create()
    {
        $player = new Player();
        $setting = Setting::first();

        return view('player.create', compact('player', 'setting'));
    }

    public function store(PlayerStoreRequest $request)
    {
        //on s'inscrit dans la saison active
        $seasonActive = Season::active()->first();

        //si il y a pas encore de saison
        if ($seasonActive === null)
        {
            return redirect()->route('home.index')->with('error', "Les inscriptions ne sont pas ouverte !");
        }

        //compte le nombre d'inscription dans lesquels on est inscrit
        $numberOfPlayerForUserInSelectedSeason = Player::select('players.id')
            ->withSeason($seasonActive->id)
            ->where('user_id', $this->user->id)
            ->count();

        //si on a plus de 1 inscription
        if ($numberOfPlayerForUserInSelectedSeason >= 1)
        {
            return redirect()->back()->with('error',
                "Vous êtes est déjà inscrit !")->withInput($request->input());
        }

        Player::create([
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
            'season_id' => $seasonActive->id,
        ]);

        return redirect()->route('home.index')->with('success', "Vous êtes bien inscrit !");
    }

    private function onPlayerCreateChoseGbc_state($request)
    {
        //on est l'admin, on peut choisir le champ
        if ($this->user->hasRole('admin'))
        {
            return $request->gbc_state;
        }
        else
        {
            //si on a choisit la formule loisir, fun, ou performance, on ne peut pas etre a GBC
            if ($request->formula === 'leisure' || $request->formula === 'fun' || $request->formula === 'performance')
            {
                return 'non_applicable';
            }
            //si on esy en corpo ou competition on doit remettre notre dossier
            elseif ($request->formula === 'corpo' || $request->formula === 'competition')
            {
                return 'entry_must';
            }
        }

        return 'non_applicable';
    }

    public function changeCeStateToContributionPaid($player_id)
    {
        $player = Player::findOrFail($player_id);

        if ($player->hasCeState('contribution_payable'))
        {
            $player->update([
                'ce_state' => 'contribution_paid',
            ]);

            return redirect()->route('player.index')->with('success', "Le joueur $player a payé sa cotisation !");
        }

        return redirect()->route('player.index')->with('error', "Le joueur $player a déjà payé sa cotisation !");
    }

    public function changeGbcStateToValid($player_id)
    {
        $player = Player::findOrFail($player_id);

        if ($player->hasGbcState('entry_must'))
        {
            $player->update([
                'gbc_state' => 'valid',
            ]);

            return redirect()->route('player.index')->with('success', "Le joueur $player a son dossier GBC valide !");
        }

        return redirect()->route('player.index')->with('error',
            "Le joueur $player est non applicable ou il a déjà validé son dossier!");
    }
}
