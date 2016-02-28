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

    public function __toString()
    {
        return strval($this->number);
    }

    public function getTypeFrench()
    {
        if($this->type == 'simple')
        {
            return 'simple';
        }
        elseif($this->type == 'simple_man')
        {
            return 'simple homme';
        }
        elseif($this->type == 'simple_woman')
        {
            return 'simple femme';
        }
        elseif($this->type == 'double')
        {
            return 'double';
        }
        elseif($this->type == 'double_man')
        {
            return 'double homme';
        }
        elseif($this->type == 'double_woman')
        {
            return 'double femme';
        }

        return 'mixte';
    }
}
