<?php

namespace App\Http\Middleware;

use App\Helpers;
use App\User;
use Closure;

class NotLeisure
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
        $user = Helpers::getInstance()->auth();

        if ($user !== null)
        {
            if ($user->hasRole('admin'))
            {
                return $next($request);

            }
            $player = Helpers::getInstance()->myPlayer();

            if ($player !== null && ! $player->hasFormula('leisure') || $player == null)
            {
                return $next($request);
            }

        }
        abort(401, 'Unauthorized action.');

        return false;
    }
}
