<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdminsReservation extends Model
{

    protected $table = 'admins_reservations';

    protected $fillable = [
        'start',
        'end',
        'title',
        'comment',
        'recurring',
        'user_id',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'recurring' => 'boolean',
        'monday'    => 'boolean',
        'tuesday'   => 'boolean',
        'wednesday' => 'boolean',
        'thursday'  => 'boolean',
        'friday'    => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function timeSlots()
    {
        return $this->belongsToMany('App\TimeSlot');
    }

    public function courts()
    {
        return $this->belongsToMany('App\Court');
    }

    /******************/
    /*      Has       */
    /******************/

    public function hasReccuring($recurring)
    {
        return $this->recurring === $recurring;
    }

    public function hasDay($day)
    {
        return $this->day === $day;
    }

    /******************/
    /*     Getters    */
    /******************/

    public function getStartAttribute($start)
    {
        $date = Carbon::createFromFormat('Y-m-d', $start);

        return $date->format('d/m/Y');
    }

    public function setStartAttribute($start)
    {
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y', $start)->format('Y-m-d');
    }

    public function getEndAttribute($end)
    {
        $date = Carbon::createFromFormat('Y-m-d', $end);

        return $date->format('d/m/Y');
    }

    public function setEndAttribute($end)
    {
        $this->attributes['end'] = Carbon::createFromFormat('d/m/Y', $end)->format('Y-m-d');
    }

}
