<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Tournament extends Model
{
    protected $table = 'tournaments';

    protected $fillable = [
        'start',
        'end',
        'table_number',
        'name',
        'season_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function series()
    {
        return $this->hasMany('App\Series');
    }

    public function __toString()
    {
        return $this->start . ' - ' . $this->end;
    }

    public function getStartAttribute($start)
    {
        return Date::createFromFormat('Y-m-d', $start);
    }

    public function setStartAttribute($start)
    {
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y', $start)->format('Y-m-d');
    }

    public function getEndAttribute($end)
    {
        return Date::createFromFormat('Y-m-d', $end);
    }

    public function setEndAttribute($end)
    {
        $this->attributes['end'] = Carbon::createFromFormat('d/m/Y', $end)->format('Y-m-d');
    }
}
