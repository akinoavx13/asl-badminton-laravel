<?php

namespace App;

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

}
