<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __constructor()
    {
        $this->user = Auth::user();

        view()->share('isAdmin', $this->user ? $this->user->role === 'admin' : false);
        view()->share('isLogged', Auth::check());
        view()->share('user', $this->user);
    }
}
