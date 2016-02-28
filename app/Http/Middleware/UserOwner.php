<?php

namespace App\Http\Middleware;

use App\Helpers;
use Closure;

class UserOwner
{
    /**
     * Check if this user is yours
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user_id = $request->route()->getParameter('user_id');
        $user = Helpers::getInstance()->auth();


        if ($user->hasOwner($user_id) || $user->hasRole('admin'))
        {

            return $next($request);
        }

        abort(401, 'Unauthorized action.');
    }
}
