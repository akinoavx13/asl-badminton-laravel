<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayersReservation extends Model
{
    protected $table = 'players_reservations';

    protected $fillable = [
        'date',
        'first_team',
        'second_team',
        'user_id',
        'time_slot_id',
        'court_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'recurring' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function timeSlot()
    {
        return $this->belongsTo('App\TimeSlot');
    }

    public function court()
    {
        return $this->belongsTo('App\Court');
    }
}
