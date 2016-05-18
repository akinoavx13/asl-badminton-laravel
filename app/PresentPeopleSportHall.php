<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresentPeopleSportHall extends Model
{
    protected $table = 'present_people_sport_hall';

    protected $fillable = [
        'user_id',
        'day',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
