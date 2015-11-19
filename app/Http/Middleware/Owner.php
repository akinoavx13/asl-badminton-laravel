<?php

namespace App\Http\Middleware;

use Closure;

class Owner
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

        $user_id = $request->route()->getParameter('user_id');
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
