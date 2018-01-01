<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'time_slots';

    protected $fillable = [
        'start',
        'end',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function playersReservations()
    {
        return $this->hasMany('App\PlayersReservation');
    }

    public function adminsReservations()
    {
        return $this->belongsToMany('App\AdminsReservation');
    }

    public function availability()
    {
        return $this->hasMany('App\Availability');
    }

    public function __toString()
    {
        return $this->start . ' - ' . $this->end;
    }

    /******************/
    /*  GET SET ATT   */
    /******************/

    public function getStartAttribute($start)
    {
        $startExplode = explode(':', $start);

        $hours = $startExplode[0];
        $minutes = $startExplode[1];

        return $hours . ':' . $minutes;
    }

    public function setStartAttribute($start)
    {
        $startExplode = explode(':', $start);

        $this->attributes['start'] = Carbon::createFromTime($startExplode[0], $startExplode[1], 0);
    }

    public function getEndAttribute($end)
    {
        $endExplode = explode(':', $end);

        $hours = $endExplode[0];
        $minutes = $endExplode[1];

        return $hours . ':' . $minutes;
    }

    public function setEndAttribute($end)
    {
        $endExplode = explode(':', $end);

        $this->attributes['end'] = Carbon::createFromTime($endExplode[0], $endExplode[1], 0);

    }

}
