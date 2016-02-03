<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChampionshipResultController extends Controller
{

    public static function routes($router)
    {
        //patterns
        $router->pattern('pool_id', '[0-9]+');

        //admin reservation create day
        $router->get('show/{pool_id}', [
            'uses' => 'ChampionshipResultController@show',
            'as'   => 'championshipResult.show',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $pool_id
     * @return \Illuminate\Http\Response
     */
    public function show($pool_id)
    {
        //
    }
}
