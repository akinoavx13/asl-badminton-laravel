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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('/', function () {
    return redirect('/home');
});

Route::group(['prefix' => 'home'], function () use ($router) {
    HomeController::routes($router);
});

Route::group(['prefix' => 'user'], function () use ($router)
{
    UserController::routes($router);
});

Route::group(['prefix' => 'season'], function () use ($router)
{
    SeasonController::routes($router);
});

Route::group(['prefix' => 'player'], function () use ($router)
{
    PlayerController::routes($router);
});

Route::group(['prefix' => 'setting'], function () use ($router)
{
    SettingController::routes($router);
});