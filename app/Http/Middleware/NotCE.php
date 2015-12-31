<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class NotCE
{
    /**
     * Forbid the CE users to have access for some pages
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user !== null && $user->hasRole('ce'))
        {
            return redirect()->route('ce.index');
        }

        return $next($request);
    }
}
