<?php

namespace App\Http\Controllers;

use App\Volunteer;
use App\Http\Requests\VolunteerRequest;
use App\User;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use App\Http\Utilities\SendMail;
use App\Player;
use App\Season;

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

        $router->get('check', [
            'uses' => 'VolunteerController@check',
            'as'   => 'volunteer.check',
        ]);
    }

    public function check()
    {
        $day = Date::today();
        $dayVolunteer = Volunteer::select('user_id', 'day', 'updated_at')->where('day', $day)->get();
        if ($dayVolunteer->count() == 0) {
            $season = Season::Active()->first()->id;
            $allPlayers = Player::select('users.email')
                    ->join('users', 'users.id', '=', 'players.user_id')
                    ->where('users.state', '<>', 'inactive')
                    ->where('users.role', '=', 'admin')
                    ->where('players.season_id', '=', $season)
                    ->orderBy('users.email', 'asc')
                    ->get()
                    ->chunk(45)
                    ->toArray();

        $allPlayers2 = [];

        foreach ($allPlayers as $index => $users) {
            foreach ($users as $user) {
                $allPlayers2[$index][] = $user['email'];
            }
        }

        $data['title'] = "Cherche un(e) volontaire pour le set";
        $data['content'] = "Pour information, personne ne s'est porté candidat pour prendre le set aujourd'hui. S'il n'y a pas de volontaire, la séance sera annulée :-( <br> Pour candidater, rendez-vous sur <a href='badminton.aslectra.com/home'>la page d'accueil du site</a>.";
        $data['writter'] = "robot@ASL-Badminton";

        foreach($allPlayers2 as $users) {
            SendMail::send($users, 'newActuality', $data, 'Badminton: Cherche un volontaire pour le set');
        }

        return redirect()->back()->with('success', 'Le mail de demande a bien été posté !');

        } else {
            return redirect()->back()->with('success', 'il y a déjà un volontaire !'); 
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biggestVolunteers = Volunteer::select('user_id')
            ->selectRaw('count(*) as count')
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        // get last 30 days
        $nbDay = 0;
        $latestVolunteers = array();

        while($nbDay <= 30)
        {
            $day = Date::today()->subDay($nbDay-1);
            if(!$day->isWeekend())
            {
                $dayVolunteer = Volunteer::select('user_id', 'day', 'updated_at')->where('day', $day)->get();
                $latestVolunteers[$nbDay][0] = ucfirst($day->format('l j F'));
                if (!$dayVolunteer->count() == 0) {
                    $latestVolunteers[$nbDay][1] = $dayVolunteer[0]->user->forname . " " . $dayVolunteer[0]->user->name;
                    if ($dayVolunteer[0]->updated_at->format('j') == $day->format('j')) {
                        $latestVolunteers[$nbDay][2] = " le même jour à " . $dayVolunteer[0]->updated_at->format('H:i');
                    } else {
                        $latestVolunteers[$nbDay][2] = " la veille à " . $dayVolunteer[0]->updated_at->format('H:i');
                    }

                } else {
                    $latestVolunteers[$nbDay][1] = "Personne";
                    $latestVolunteers[$nbDay][2] = "";
                }
            }
            $nbDay++;
        }

        return view('volunteer.index', compact('biggestVolunteers', 'latestVolunteers'));
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

        // // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
        $todayDayOfWeek = Carbon::today()->dayOfWeek;
        $isWeekEnd = false;

        // if today between tuesday and thrusday no problem for yesterday and tomorrow
        if ($todayDayOfWeek >= 2 and $todayDayOfWeek <= 4) {
            $today = Date::today();
            $tomorrow = Date::today()->addDay();
        } else if ($todayDayOfWeek == 0) {
            $today = Date::today();
            $isWeekEnd = true;
            $tomorrow = Date::today()->addDay();
        } else if ($todayDayOfWeek == 1) {
            $today = Date::today();
            $tomorrow = Date::today()->addDay();
        } else if ($todayDayOfWeek == 5) {
            $today = Date::today();
            $tomorrow = Date::today()->addDay(3);
        } else if ($todayDayOfWeek == 6) {
            $today = Date::today();
            $isWeekEnd = true;
            $tomorrow = Date::today()->addDay(2);
        } 

        if ($date == 'today' || $date == 'tomorrow') {
            if ($date == 'today') {
                $presentDate = $today;
            } else if ($date == 'tomorrow') {
                $presentDate = $tomorrow;
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
