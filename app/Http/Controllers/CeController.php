<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Player;
use App\Season;

class CeController extends Controller
{
    public static function routes($router)
    {
        //ce home
        $router->get('/', [
            'uses' => 'CeController@index',
            'as'   => 'ce.index',
        ]);
    }

    public function index()
    {

        $season = Season::active()->first();

        $players = Player::orderByForname()
            ->select('players.*')
            ->withSeason($season->id)
            ->get();

        $tShirt['number'] = 0;
        $tShirt['price'] = 0;

        $leisure['number'] = 0;
        $leisure['price'] = 0;

        $fun['number'] = 0;
        $fun['price'] = 0;

        $performance['number'] = 0;
        $performance['price'] = 0;

        $corpo['number'] = 0;
        $corpo['price'] = 0;

        $competition['number'] = 0;
        $competition['price'] = 0;

        $contributionUnPaid['number'] = 0;

        foreach ($players as $player)
        {
            //calculate t-shirt
            if ($player->hasTShirt(true))
            {
                $tShirt['price'] += 25;
                $tShirt['number']++;
            }

            //calculate leisure formula
            if ($player->hasFormula('leisure'))
            {
                $leisure['price'] += $player->user->hasLectraRelation('external') ? 100 : 10;
                $leisure['number']++;
            }

            //calculate fun formula
            if ($player->hasFormula('fun'))
            {
                $fun['price'] += $player->user->hasLectraRelation('external') ? 100 : 20;
                $fun['number']++;
            }

            //calculate performance formula
            if ($player->hasFormula('performance'))
            {
                $performance['price'] += $player->user->hasLectraRelation('external') ? 100 : 30;
                $performance['number']++;
            }

            //calculate corpo formula
            if ($player->hasFormula('corpo'))
            {
                $corpo['price'] += $player->user->hasLectraRelation('external') ? 100 : 40;
                $corpo['number']++;
            }

            //calculate competition formula
            if ($player->hasFormula('competition'))
            {
                $competition['price'] += $player->user->hasLectraRelation('external') ? 200 : 80;
                $competition['number']++;
            }

            //contribution paid
            if ($player->hasCeState('contribution_payable'))
            {
                $contributionUnPaid['number']++;
            }
        }

        return view('ce.index', compact('players', 'tShirt', 'leisure', 'fun', 'performance', 'corpo', 'competition',
            'contributionUnPaid'));
    }
}
