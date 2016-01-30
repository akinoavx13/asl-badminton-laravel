<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'periods';

    protected $fillable = [
        'start',
        'end',
        'season_id',
        'type',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    public function pools()
    {
        return $this->hasMany('App\ChampionshipPool');
    }

    /******************/
    /*  GET SET ATT   */
    /******************/

    public function getStartAttribute($start)
    {
        return Carbon::createFromFormat('Y-m-d', $start);
    }

    public function setStartAttribute($start)
    {
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y', $start)->format('Y-m-d');
    }

    public function getEndAttribute($end)
    {
        return Carbon::createFromFormat('Y-m-d', $end);
    }

    public function setEndAttribute($end)
    {
        $this->attributes['end'] = Carbon::createFromFormat('d/m/Y', $end)->format('Y-m-d');
    }

    /******************/
    /*     scopes     */
    /******************/

    public function scopeCurrent($query, $season_id)
    {
        $today = Carbon::today();
        $query->where('season_id', $season_id)
            ->where('start', '<=', $today)
            ->where('end', '>=', $today);
    }
}
