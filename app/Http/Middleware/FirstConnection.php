<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class FirstConnection
{
    /**
     * Check if this is the first time that the user connect to the site
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = $request->route()->getParameter('user_id');
        $token_first_connection = $request->route()->getParameter('token_first_connection');
        $user = User::where('id', $user_id)->where('token_first_connection', $token_first_connection)->first();
        
        if ($user !== null && $user->hasFirstConnection(true))
        {
            return $next($request);
        }
        else
        {
            abort(401, 'Unauthorized action.');
        }
    }
}
