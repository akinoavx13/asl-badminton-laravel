<?php

namespace App\Http\Controllers;

use App\Http\Utilities\SendMail;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmailToDevController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        $router->get('/index', [
            'uses' => 'EmailToDevController@index',
            'as'   => 'emailToDev.index',
        ]);

        $router->post('/index', [
            'uses' => 'EmailToDevController@send',
            'as'   => 'emailToDev.send',
        ]);
    }

    public function index()
    {
        return view('emailToDev.index');
    }

    public function send(Request $request)
    {
        if ($request->exists('content'))
        {
            $dev = User::where('email', 'imaxame@gmail.com')->first();
            if ($dev !== null)
            {

                $data['sender'] = $this->user->forname . " " . $this->user->name;
                $data['content'] = $request->get('content');
                $data['dev'] = $dev->forname . " " . $dev->name;

                SendMail::send($dev, 'emailToDev', $data, 'Email au développeur AS Lectra Badminton');
            }
        }


    }
}
