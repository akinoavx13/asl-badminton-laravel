<?php

namespace App\Http\Middleware;

use App\Helpers;
use App\Setting;
use Closure;

class SettingExists
{
    /**
     * Check if they is a setting
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $setting = Helpers::getInstance()->setting();

        if ($setting !== null)
        {
            return $next($request);
        }

        return redirect()->back()->with('error', "Il faut d'abord créer la page paramètre !");
    }
}
