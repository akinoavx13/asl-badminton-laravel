<?php

namespace App\Http\Middleware;

use Closure;

class NotUser
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
        $user = $request->user();

        if ($user !== null & $user->hasRole('user'))
        {
            abort(401, 'Unauthorized action.');
        }
        else
        {
            return $next($request);
        }
    }
}
