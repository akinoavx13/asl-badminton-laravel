<?php

namespace App\Http\Controllers;

use App\AdminsReservation;
use App\Court;
use App\Http\Requests\AdminReservationStoreRequest;
use App\TimeSlot;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminReservationController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {
        //admin reservation create day
        $router->get('create', [
            'uses' => 'AdminReservationController@create',
            'as'   => 'adminReservation.create',
        ]);

        //admin reservation create day
        $router->post('create', [
            'uses' => 'AdminReservationController@store',
            'as'   => 'adminReservation.store',
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adminReservation = new AdminsReservation();
        $courts = Court::orderBy('number')->get();
        $timeSlots = TimeSlot::orderBy('start')->get();

        return view('adminReservation.create', compact('adminReservation', 'courts', 'timeSlots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminReservationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminReservationStoreRequest $request)
    {
        $adminReservation = AdminsReservation::create([
            'start'     => $request->start,
            'title'     => $request->title,
            'comment'   => $request->exists('comment') && $request->comment !== "" ? $request->comment : null,
            'recurring' => $request->recurring,
            'user_id'   => $this->user->id,
        ]);

        if ($adminReservation->hasReccuring(true))
        {
            $adminReservation->update([
                'end' => $request->end,
            ]);

            foreach ($request->day as $day)
            {
                $adminReservation->update([
                    $day => true,
                ]);
            }
        }

        foreach ($request->court_id as $court_id)
        {
            DB::table('admins_reservation_court')->insert([
                'admins_reservation_id' => $adminReservation->id,
                'court_id'              => $court_id,
            ]);
        }

        foreach ($request->timeSlot_id as $timeSlot_id)
        {
            DB::table('admins_reservation_time_slot')->insert([
                'admins_reservation_id' => $adminReservation->id,
                'time_slot_id'          => $timeSlot_id,
            ]);
        }

        return redirect()->back()->with('success', "Les réservations sont bien bloquées !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}
