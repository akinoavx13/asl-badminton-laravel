<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Period extends Model
{
    protected $table = 'periods';

    protected $fillable = [
        'start',
        'end',
        'season_id',
        'type',
        'championship_simple_woman',
        'championship_double_woman',
    ];

    protected $casts = [
        'championship_simple_woman' => 'boolean',
        'championship_double_woman' => 'boolean',
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

    public function hasChampionshipSimpleWoman($championshipSimpleWoman)
    {
        return $this->championship_simple_woman === $championshipSimpleWoman;
    }

    public function hasChampionshipDoubleWoman($championshipDoubleWoman)
    {
        return $this->championship_double_woman === $championshipDoubleWoman;
    }

    /******************/
    /*     scopes     */
    /******************/

    public function scopeCurrent($query, $season_id, $type)
    {
        $today = Carbon::today();
        $query->where('type', $type)
            ->where('season_id', $season_id)
            ->where('start', '<=', $today)
            ->where('end', '>=', $today);
    }

    public function scopeLasted($query, $season_id, $type)
    {
        $today = Carbon::today();
        $query->where('type', $type)
            ->where('season_id', $season_id)
            ->where('end', '<', $today)
            ->orderBy('end', 'desc');
    }
}
