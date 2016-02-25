<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardAdminController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {

        $router->get('/index', [
            'uses' => 'DashboardAdminController@index',
            'as'   => 'dashboardAdmin.index',
        ]);

    }

    public function index()
    {
        return view('dashboardAdmin.index');
    }

}
