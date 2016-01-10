<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \App\Http\Middleware\UserAdmin::class,
        'userOwner'   => \App\Http\Middleware\UserOwner::class,
        'playerOwner' => \App\Http\Middleware\PlayerOwner::class,
        'firstConnection' => \App\Http\Middleware\FirstConnection::class,
        'enrollOpen'    => \App\Http\Middleware\EnrollOpen::class,
        'settingExists' => \App\Http\Middleware\SettingExists::class,
        'buyTshirtClose' => \App\Http\Middleware\BuyTshirtClose::class,
        'notCE'   => \App\Http\Middleware\NotCE::class,
        'notUser' => \App\Http\Middleware\NotUser::class,
        'notLeisure' => \App\Http\Middleware\NotLeisure::class,
    ];
}
