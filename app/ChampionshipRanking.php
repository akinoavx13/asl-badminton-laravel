<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChampionshipRanking extends Model
{
    protected $table = 'championship_rankings';

    protected $fillable = [
        'match_played',
        'match_to_play',
        'match_won',
        'match_lost',
        'match_unplayed',
        'match_won_by_wo',
        'match_lost_by_wo',
        'total_difference_set',
        'total_difference_points',
        'total_points',
        'rank',
        'championship_pool_id',
        'team_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function championshipPool()
    {
        return $this->belongsTo('App\ChampionshipPool');
    }
}
