<?php

namespace App\Http\Middleware;

use Closure;

class UserAdmin
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
        if ($request->user()->hasRole('admin')) {
            return $next($request);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
