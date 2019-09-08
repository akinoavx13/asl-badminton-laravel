<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddingRopeRequest;
use App\Http\Utilities\SendMail;
use App\Rope;
use App\User;
use App\Http\Requests\RopeRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RopeController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        $router->get('index', [
            'uses' => 'RopeController@index',
            'as'   => 'rope.index',
        ]);

        $router->post('withdrawal', [
            'uses' => 'RopeController@withdrawal',
            'as'   => 'rope.withdrawal',
        ]);

        $router->get('create', [
            'middleware' => 'admin',
            'uses'       => 'RopeController@create',
            'as'         => 'rope.create',
        ]);

        $router->post('create', [
            'middleware' => 'admin',
            'uses'       => 'RopeController@adding',
            'as'         => 'rope.adding',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdrawal = Rope::where('fill', false)->sum('rest');
        $adding = Rope::where('fill', true)->sum('rest');

        $rest = $adding - $withdrawal;

        $myConsumption = Rope::where('user_id', $this->user->id)->where('fill', false)->orderBy('created_at', 'desc')->get();
        $myTension = $this->user->tension;

        return view('rope.index', compact('rest', 'myConsumption', 'myTension'));
    }

    public function withdrawal(RopeRequest $request)
    {
        
        Rope::create([
            'user_id' => $this->user->id,
            'rest'    => 1,
            'fill'    => false,
            'tension' => $request->tension,
            'comment' => $request->comment,
        ]);

        if ($request->tension != $this->user->tension) {
            $this->user->update(['tension' => $request->tension,]);
        }

        if (env('APP_ENV') == 'prod')
        {
            SendMail::send($this->user, 'takeRope', array('name' => $this->user->name, 'forname' => $this->user->forname, 'tension' => $request->tension, 'comment' => $request->comment), 'Demande de cordage AS Lectra
        Badminton', true);
        }

        return redirect()->route('home.index')->with('success',
            "Le cordage de votre raquette vient d'être enregistré, un mail a été envoyé à Cestas Sport");
    }

    public function create()
    {
        $withdrawal = Rope::where('fill', false)->sum('rest');
        $adding = Rope::where('fill', true)->sum('rest');

        $rest = $adding - $withdrawal;

        $ropes = Rope::select('users.name', 'users.forname', 'ropes.created_at', 'ropes.rest', 'ropes.fill')
            ->join('users', 'users.id', '=', 'ropes.user_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rope.create', compact('rest', 'ropes'));
    }

    public function adding(AddingRopeRequest $request)
    {
        $rope = Rope::create([
            'user_id' => $this->user->id,
            'rest'    => $request->rest,
            'fill'    => true,
        ]);

        $rest = $rope->rest;

        return redirect()->back()->with('success', "L'approvisionnement de $rest cordage a bien été enregistré");
    }

}
