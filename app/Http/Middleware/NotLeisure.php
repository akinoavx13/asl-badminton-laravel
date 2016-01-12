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
            $player = Helpers::getInstance()->myPlayer();

            if ($player !== null)
            {
                if (! $player->hasFormula('leisure'))
                {
                    return $next($request);
                }
                else
                {
                    abort(401, 'Unauthorized action.');
                }
            }
            else
            {
                abort(401, 'Unauthorized action.');
            }
        }
        else
        {
            abort(401, 'Unauthorized action.');
        }
    }
}
