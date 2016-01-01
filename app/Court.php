<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $table = 'courts';

    protected $fillable = [
        'type',
        'number',
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
