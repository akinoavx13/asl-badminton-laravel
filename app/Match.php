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
        'table_rank',
        'table_id',
        'next_match_winner_id',
        'next_match_looser_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function table()
    {
        return $this->belongsTo('App\Table');
    }
}
