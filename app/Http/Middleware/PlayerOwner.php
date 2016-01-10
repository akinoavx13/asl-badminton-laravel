<?php

namespace App\Http\Middleware;

use App\Helpers;
use App\Player;
use Closure;

class PlayerOwner
{
    /**
     * Check if the player is yours
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $player_id = $request->route()->getParameter('player_id');
        $player = Player::findOrFail($player_id);
        $user_id = $player->user->id;

        $user = Helpers::getInstance()->auth();

        if ($user->hasOwner($user_id) || $user->hasRole('admin'))
        {
            return $next($request);
        }
        else
        {
            abort(401, 'Unauthorized action.');
        }

    }
}
