<?php

namespace App\Providers;

use App\Helpers;
use App\User;
use Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            $auth = Helpers::getInstance()->auth();

            $view->with('auth', $auth);

            if($auth !== null)
            {
                $myPlayer = Helpers::getInstance()->myPlayer();
                $view->with('myPlayer', $myPlayer);
            }

        });
    }

    /**w
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
