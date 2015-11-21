<?php

namespace App\Http\Middleware;

use App\Player;
use Closure;

class PlayerOwner
{
    /**
     * Handle an incoming request.
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

        $user = $request->user();

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
