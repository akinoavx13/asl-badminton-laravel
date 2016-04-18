<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'matches_number_in_table',
        'first_team_id',
        'second_team_id',
        'series_rank',
        'series_id',
        'next_match_winner_id',
        'next_match_looser_id',
        'team_number_winner',
        'team_number_looser',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        return 'Match n° ' . $this->matches_number_in_table;
    }

    public function series()
    {
        return $this->belongsTo('App\Series');
    }
}
