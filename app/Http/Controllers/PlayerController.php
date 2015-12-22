<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests\PlayerListRequest;
use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Player;
use App\Season;
use App\Setting;
use App\Team;


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
            'middleware' => ['playerOwner', 'settingExists'],
            'uses'       => 'PlayerController@edit',
            'as'         => 'player.edit',
        ]);

        //player update
        $router->post('/edit/{player_id}', [
            'middleware' => ['playerOwner', 'buyTshirtClose', 'settingExists'],
            'uses'       => 'PlayerController@update',
            'as'         => 'player.update',
        ]);

        //player create
        $router->get('/create', [
            'middleware' => ['enrollOpen', 'settingExists'],
            'uses'       => 'PlayerController@create',
            'as'         => 'player.create',
        ]);

        //player store
        $router->post('/create', [
            'middleware' => ['enrollOpen', 'buyTshirtClose', 'settingExists'],
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

        if ($request->exists('season_id'))
        {
            $season = Season::findOrFail($request->season_id);
        }
        else
        {
            $season = Season::active()->first();
            if ($season == null)
            {
                // situation anormale, il doit toujours exiter une saison active
                abort(404);
            }
        }

        $players = Player::select('players.*')
            ->with('user')
            ->join('users', 'users.id', '=', 'players.user_id')
            ->orderByForname()
            ->withSeason($season->id)
            ->get();

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
        $setting = Helpers::getInstance()->setting();

        $listPartnerAvailable['double'] = Team::listParnterAvailable('double',
            $this->user->hasGender('man') ? 'man' : 'woman', $player_id);
        $listPartnerAvailable['mixte'] = Team::listParnterAvailable('mixte',
            $this->user->hasGender('man') ? 'woman' : 'man', $player_id);

        return view('player.edit', compact('player', 'setting', 'listPartnerAvailable'));
    }

    public function update(PlayerUpdateRequest $request, $player_id)
    {
        $player = Player::findOrFail($player_id);
        $activeSeason = Season::active()->first();

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
            // tshirt inclus dans les formules competition et corpo, pas dans les autres
            't_shirt'     => $request->formula === 'leisure' || $request->formula === 'fun' || $request->formula === 'performance' ? $request->t_shirt : true,
            'simple'      => $request->formula !== 'leisure' ? $request->simple : false,
            'double'      => $request->formula !== 'leisure' ? $request->double : false,
            'mixte'       => $request->formula !== 'leisure' ? $request->mixte : false,
            'corpo_man'   => ($request->formula === 'corpo' || $request->formula === 'competition') && $player->user->hasGender('man') ? $request->corpo_man : false,
            'corpo_woman' => ($request->formula === 'corpo' || $request->formula === 'competition') && $player->user->hasGender('woman') ? $request->corpo_woman : false,
            'corpo_mixte' => $request->formula === 'corpo' || $request->formula === 'competition' ? $request->corpo_mixte : false,
        ]);

        $this->createSimpleTeams($player, $activeSeason);

        return redirect()->route('home.index')->with('success', "Les modifications sont bien prise en compte !");
    }

    public function create()
    {
        $player = new Player();
        $setting = Helpers::getInstance()->setting();

        $listPartnerAvailable['double'] = Team::listParnterAvailable('double',
            $this->user->hasGender('man') ? 'man' : 'woman');
        $listPartnerAvailable['mixte'] = Team::listParnterAvailable('mixte',
            $this->user->hasGender('man') ? 'woman' : 'man');

        return view('player.create', compact('player', 'setting', 'listPartnerAvailable'));
    }

    public function store(PlayerStoreRequest $request)
    {
        //on s'inscrit dans la saison active
        $activeSeason = Season::active()->first();

        //si il y a pas encore de saison
        if ($activeSeason === null)
        {
            return redirect()->route('home.index')->with('error', "Les inscriptions ne sont pas ouverte !");
        }

        //compte le nombre d'inscription dans lesquels on est inscrit
        $numberOfPlayerForUserInSelectedSeason = Player::select('players.id')
            ->withSeason($activeSeason->id)
            ->where('user_id', $this->user->id)
            ->count();

        //si on a plus de 1 inscription
        if ($numberOfPlayerForUserInSelectedSeason >= 1)
        {
            return redirect()->back()->with('error',
                "Vous êtes est déjà inscrit !")->withInput($request->input());
        }

        $player = Player::create([
            'formula'     => $request->formula,
            // tshirt inclus dans les formules competition et corpo, pas dans les autres
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
            'season_id'   => $activeSeason->id,
        ]);

        $this->createSimpleTeams($player, $activeSeason);

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

            return redirect()->back()->with('success', "Le joueur $player a payé sa cotisation !");
        }

        return redirect()->back()->with('error', "Le joueur $player a déjà payé sa cotisation !");
    }

    public function changeGbcStateToValid($player_id)
    {
        $player = Player::findOrFail($player_id);

        if ($player->hasGbcState('entry_must'))
        {
            $player->update([
                'gbc_state' => 'valid',
            ]);

            return redirect()->back()->with('success', "Le joueur $player a son dossier GBC valide !");
        }

        return redirect()->back()->with('error',
            "Le joueur $player est non applicable ou il a déjà validé son dossier!");
    }

    private function createSimpleTeams($player, $activeSeason)
    {
        //Toutes les équipes de simple, active ou pas. On met first parce qu'il ne peut y en avoir qu'une seule
        $allMySimpleTeams = Team::allMySimpleTeams($this->user->hasGender('man') ? 'man' : 'woman',
            $player->id, $activeSeason->id)
            ->first();

        //si j'ai une équipe de simple, on met à jour le statut enable
        if ($allMySimpleTeams !== null)
        {
            $allMySimpleTeams->update([
                'enable' => $player->simple,
            ]);
        }

        if ($player->hasSimple(true) && $allMySimpleTeams === null)
        {
            //si on a pas encore d'équipe, il faut en créer une
            Team::create([
                'player_one'   => $player->id,
                'player_two'   => null,
                'season_id'    => $activeSeason->id,
                'simple_man'   => $this->user->hasGender('man') ? true : false,
                'simple_woman' => $this->user->hasGender('man') ? false : true,
                'double_man'   => false,
                'double_woman' => false,
                'mixte'        => false,
                'enable'       => true,
            ]);
        }
    }

    private function createDoubleTeams($player, $activeSeason)
    {
        /*
         * pour simple, double et mixte, il faut en premier lieu chercher si l'equipe existe ou pas
         * (y compris les equipes qui ne sont pas 'enable'). Si elle existe on la passe à 'enable' sinon on la crée
         *
         * pour les equipes double et mixte, il faudra mettre à 'disable' les equipes du partenaire précédent
         *
         * a la fin il faut s'assurer que pour la saison en cours il n'y a qu'une seule equipe 'enable' par type
         * pour ce joueur
         */

        //toutes mes équipe de double, active ou pas
        $allMyDoubleTeams = Team::allMyDoubleOrMixteTeams('double', $this->user->hasGender('man') ? 'man' : 'woman',
            $player->id, $activeSeason->id)
            ->get();

    }
}
