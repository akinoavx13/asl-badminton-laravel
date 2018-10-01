<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSlotStoreRequest;
use App\Http\Requests\TimeSlotUpdateRequest;
use App\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimeSlotController extends Controller
{

    public static function routes($router)
    {
        //patterns
        $router->pattern('timeSlot_id', '[0-9]+');

        //timeSlot list
        $router->get('/index', [
            'uses' => 'TimeSlotController@index',
            'as'   => 'timeSlot.index',
        ]);

        //timeSlot edit
        $router->get('/edit/{timeSlot_id}', [
            'uses' => 'TimeSlotController@edit',
            'as'   => 'timeSlot.edit',
        ]);

        //timeSlot update
        $router->post('/update/{timeSlot_id}', [
            'uses' => 'TimeSlotController@update',
            'as'   => 'timeSlot.update',
        ]);

        //timeSlot create
        $router->get('/create', [
            'uses' => 'TimeSlotController@create',
            'as'   => 'timeSlot.create',
        ]);

        //timeSlot store
        $router->post('/store', [
            'uses' => 'TimeSlotController@store',
            'as'   => 'timeSlot.store',
        ]);

        //timeSlot delete
        $router->get('/delete/{timeSlot_id}', [
            'uses' => 'TimeSlotController@delete',
            'as'   => 'timeSlot.delete',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeSlots = TimeSlot::all();

        return view('timeSlot.index', compact('timeSlots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $timeSlot = new TimeSlot();

        return view('timeSlot.create', compact('timeSlot'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeSlotStoreRequest $request)
    {
        $timeSlot = TimeSlot::create([
            'start' => $request->start,
            'end'   => $request->end,
        ]);

        return redirect()->route('timeSlot.index')->with('success', "Le crénaux $timeSlot vient d'être créé !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($timeSlot_id)
    {
        $timeSlot = TimeSlot::findOrFail($timeSlot_id);

        return view('timeSlot.edit', compact('timeSlot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TimeSlotUpdateRequest $request, $timeSlot_id)
    {
        $timeSlot = TimeSlot::findOrFail($timeSlot_id);

        $timeSlot->update([
            'start' => $request->start,
            'end'   => $request->end,
        ]);

        return redirect()->route('timeSlot.index')->with('success', "Les modifications sont bien prises en compte !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($timeSlot_id)
    {
        $timeSlot = TimeSlot::findOrFail($timeSlot_id);
        $timeSlot->delete();

        return redirect()->route('timeSlot.index')->with('success', "Le créneaux $timeSlot vient d'être supprimé !");
    }
}
