<?php

namespace App;

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
        'day',
        'user_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'recurring' => 'boolean',
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

}
