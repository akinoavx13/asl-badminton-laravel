<?php

namespace App\Http\Controllers;

use App\Volunteer;
use App\Http\Requests\VolunteerRequest;
use App\User;
use Carbon\Carbon;
use Jenssegers\Date\Date;


use App\Http\Requests;
use App\Http\Controllers\Controller;



class VolunteerController extends Controller
{

    public function __construct()
    {
        parent::__constructor();
    }

    public static function routes($router)
    {

        $router->pattern('date', '[a-z]+');
        $router->pattern('volunteer_id', '[0-9]+');

        $router->get('index', [
            'uses' => 'VolunteerController@index',
            'as' => 'volunteer.index',
        ]);

        //$router->get('create/{date}/{user_id}', [
        //    'uses' => 'VolunteerController@create',
        //    'as' => 'volunteer.create',
        //]);

        $router->post('create', [
            'uses' => 'VolunteerController@create',
            'as'   => 'volunteer.create',
        ]);

        $router->get('delete/{volunteer_id}', [
            'uses' => 'VolunteerController@delete',
            'as' => 'volunteer.delete',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $volunteerYesterday = Volunteer::where('day', Carbon::yesterday())->get();
        $volunteerToday = Volunteer::where('day', Carbon::today())->get();
        $volunteerTomorrow = Volunteer::where('day', Carbon::tomorrow())->get();

        $biggestVolunteers = Volunteer::select('user_id')
            ->selectRaw('count(*) as count')
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        $latestVolunteers = Volunteer::select('user_id', 'day')
            ->orderBy('day', 'desc')
            ->take(30)
            ->get();

        foreach ($latestVolunteers as $index => $oneVolunteer)
        {
            $oneDay = Date::createFromFormat('Y-m-d', $oneVolunteer['day']);
            $oneDay = ucfirst($oneDay->format('l j F Y'));
            $latestVolunteers[$index]['day'] = $oneDay;
        }

        return view('volunteer.index', compact('volunteerYesterday', 'volunteerToday', 'volunteerTomorrow', 'biggestVolunteers', 'latestVolunteers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(VolunteerRequest $request)
    {
        //
        $presentDate = null;
        //dd($request);

        //$user = User::findOrFail($this->user->id);
        $user_id = $this->user->id;
        $date = $request->dateresp;

        if ($date == 'today' || $date == 'tomorrow') {
            if ($date == 'today') {
                $presentDate = Carbon::today();
            } else if ($date == 'tomorrow') {
                $presentDate = Carbon::tomorrow();
            }

            //search if we are already at the volunteer
            $alreadyPresent = Volunteer::where('user_id', $user_id)->where('day', $presentDate)->count();

            if ($alreadyPresent == 0) {
                Volunteer::create([
                    'user_id' => $user_id,
                    'day' => $presentDate
                ]);

                

                return redirect()->back()->with('success', "Merci vous êtes responsable du set !");
            } else {
                return redirect()->back()->with('error', "Vous êtes déjà responsable du set !");
            }

        }

        return redirect()->back()->with('error', "Vous ne pouvez être responsable que aujourd'hui ou demain");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($volunteer_id)
    {
        $volunteer = Volunteer::findOrFail($volunteer_id);
        $volunteer->delete();

        return redirect()->back()->with('success', "Vous n'êtes plus responsable pour le set");  
    }
}
