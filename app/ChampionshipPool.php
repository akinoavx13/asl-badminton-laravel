<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChampionshipPool extends Model
{
    protected $table = 'championship_pools';

    protected $fillable = [
        'number',
        'type',
        'period_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function period()
    {
        return $this->belongsTo('App\Period');
    }

    public function championshipRanks()
    {
        return $this->hasMany('App\ChampionshipRanking');
    }
}
