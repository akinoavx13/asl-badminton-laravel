<?php

namespace App\Http\Middleware;

use Closure;

class UserAdmin
{
    /**
     * Check if you're an admin
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->hasRole('admin')) {
            return $next($request);
        } else {
            abort(401, 'Unauthorized action.');
        }
    }
}
