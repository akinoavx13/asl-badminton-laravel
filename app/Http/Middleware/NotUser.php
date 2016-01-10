<?php

namespace App\Http\Middleware;

use App\Helpers;
use Closure;

class NotUser
{
    /**
     * Forbid the users to have access for some pages
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Helpers::getInstance()->auth();

        if ($user !== null && $user->hasRole('user'))
        {
            abort(401, 'Unauthorized action.');
        }
        else
        {
            return $next($request);
        }
    }
}
