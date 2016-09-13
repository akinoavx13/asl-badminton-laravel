<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests;
use App\Player;
use App\Season;
use App\Setting;
use Illuminate\Http\Request;

/**
 * Manage Lectra budget
 *
 * Class CeController
 * @package App\Http\Controllers
 */
class CeController extends Controller
{
    /**
     * @param $router
     */
    public static function routes($router)
    {
        //Lectra budget
        $router->get('/', [
            'middleware' => 'settingExists',
            'uses'       => 'CeController@index',
            'as'         => 'ce.index',
        ]);

        //Lectra budget
        $router->post('/', [
            'middleware' => 'settingExists',
            'uses'       => 'CeController@index',
            'as'         => 'ce.index',
        ]);
    }

    /**
     * View Lectra budget
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $seasons = [];

        foreach (Season::orderBy('created_at')->get() as $value) {
            $seasons[$value->id] = 'Saison ' . $value->name;
        }

        $season = Season::active()->first();

        if ($request->isMethod('POST')) {
            $season = Season::findOrFail($request->season_id);
        }

        $setting = Helpers::getInstance()->setting();

        $players = Player::select('players.*')
            ->with('user')
            ->join('users', 'users.id', '=', 'players.user_id')
            ->orderByForname()
            ->withSeason($season->id)
            ->get();

        $tShirt['number'] = 0;
        $tShirt['price'] = 0;

        $leisure['number'] = 0;
        $leisure['price'] = 0;

        $fun['number'] = 0;
        $fun['price'] = 0;

        $tournament['number'] = 0;
        $tournament['price'] = 0;

        $performance['number'] = 0;
        $performance['price'] = 0;

        $corpo['number'] = 0;
        $corpo['price'] = 0;

        $competition['number'] = 0;
        $competition['price'] = 0;

        $contributionUnPaid['number'] = 0;

        $totalPayable = 0;
        $totalPaid = 0;

        foreach ($players as $player)
        {
            $playerPrice = $player->totalPrice($setting);

            $tShirt['price'] += $playerPrice['t_shirt'];
            $tShirt['number'] += $playerPrice['t_shirt'] !== 0 ? 1 : 0;

            $totalPayable += $playerPrice['t_shirt'] + $playerPrice['formula'];

            if ($player->hasCeState('contribution_payable'))
            {
                $contributionUnPaid['number']++;
            }
            elseif ($player->hasCeState('contribution_paid'))
            {
                $totalPaid += $playerPrice['t_shirt'] + $playerPrice['formula'];
            }

            //calculate leisure formula
            if ($player->hasFormula('leisure'))
            {
                $leisure['number']++;
                $leisure['price'] += $playerPrice['formula'];
            }

            //calculate fun formula
            elseif ($player->hasFormula('tournament'))
            {
                $tournament['number']++;
                $tournament['price'] += $playerPrice['formula'];
            }

            //calculate fun formula
            elseif ($player->hasFormula('fun'))
            {
                $fun['number']++;
                $fun['price'] += $playerPrice['formula'];
            }

            //calculate performance formula
            elseif ($player->hasFormula('performance'))
            {
                $performance['number']++;
                $performance['price'] += $playerPrice['formula'];
            }

            //calculate corpo formula
            elseif ($player->hasFormula('corpo'))
            {
                $corpo['number']++;
                $corpo['price'] += $playerPrice['formula'];
            }

            //calculate competition formula
            elseif ($player->hasFormula('competition'))
            {
                $competition['number']++;
                $competition['price'] += $playerPrice['formula'];
            }
        }

        return view('ce.index',
            compact('players', 'tShirt', 'leisure', 'tournament', 'fun', 'performance', 'corpo', 'competition', 'contributionUnPaid',
                'setting', 'totalPayable', 'totalPaid', 'seasons', 'season'));
    }
}
