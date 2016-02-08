<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\CeController;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ChampionshipResultController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerReservationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\UserController;

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->where('token', '[a-zA-Z0-9]+');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('/', function () {
    return redirect('/home');
});

Route::group(['prefix' => 'home', 'middleware' => ['notCE', 'auth']], function () use ($router)
{
    HomeController::routes($router);
});

Route::group(['prefix' => 'user', 'middleware' => ['notCE', 'auth']], function () use ($router)
{
    UserController::routes($router);
});

Route::group(['prefix' => 'season', 'middleware' => ['notCE', 'auth', 'admin']], function () use ($router)
{
    SeasonController::routes($router);
});

Route::group(['prefix' => 'player', 'middleware' => ['notCE', 'auth']], function () use ($router)
{
    PlayerController::routes($router);
});

Route::group(['prefix' => 'setting', 'middleware' => ['auth', 'notCE', 'admin']], function () use ($router)
{
    SettingController::routes($router);
});

Route::group(['prefix' => 'ce', 'middleware' => 'notUser'], function () use ($router)
{
    CeController::routes($router);
});

Route::group(['prefix' => 'court', 'middleware' => ['auth', 'notCE', 'admin']], function () use ($router)
{
    CourtController::routes($router);
});

Route::group(['prefix' => 'timeSlot', 'middleware' => ['auth', 'notCE', 'admin']], function () use ($router)
{
    TimeSlotController::routes($router);
});

Route::group(['prefix' => 'reservation', 'middleware' => ['auth', 'notCE', 'notLeisure']], function () use ($router)
{
    ReservationController::routes($router);
});

Route::group(['prefix' => 'playerReservation', 'middleware' => ['auth', 'notCE', 'notLeisure']], function () use
($router)
{
    PlayerReservationController::routes($router);
});

Route::group(['prefix' => 'adminReservation', 'middleware' => ['auth', 'admin', 'notCE']], function () use
($router)
{
    AdminReservationController::routes($router);
});

Route::group(['prefix' => 'championship', 'middleware' => ['auth', 'notCE', 'admin', 'notLeisure']], function () use ($router)
{
    ChampionshipController::routes($router);
});

Route::group(['prefix' => 'testimonial', 'middleware' => ['auth', 'notCE']], function () use ($router)
{
    TestimonialController::routes($router);
});

Route::group(['prefix' => 'championshipResult', 'middleware' => ['auth', 'notCE', 'notLeisure']], function () use ($router)
{
    ChampionshipResultController::routes($router);
});

Route::group(['prefix' => 'scores', 'middleware' => ['auth', 'notCE', 'notLeisure']], function () use ($router)
{
    ScoreController::routes($router);
});