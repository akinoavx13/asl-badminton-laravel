<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddingRopeRequest;
use App\Rope;
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

        $router->get('withdrawal', [
            'uses' => 'RopeController@withdrawal',
            'as'   => 'rope.withdrawal',
        ]);

        $router->get('create', [
            'middleware' => 'admin',
            'uses' => 'RopeController@create',
            'as'   => 'rope.create',
        ]);

        $router->post('create', [
            'middleware' => 'admin',
            'uses' => 'RopeController@adding',
            'as'   => 'rope.adding',
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

        return view('rope.index', compact('rest'));
    }

    public function withdrawal()
    {
        Rope::create([
            'user_id' => $this->user->id,
            'rest'    => 1,
            'fill'    => false,
        ]);

        return redirect()->route('home.index')->with('success', "Le cordage de votre raquette vient d'être enregistré, un mail a été envoyé à Cestas Sport");
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

        return redirect()->back()->with('success', "L'approvisionnement de $rest cordage est bien enregistré");
    }

}
