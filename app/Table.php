<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = [
        'category',
        'display_order',
        'name',
        'number_matches_rank_1',
        'number_rank',
        'tournament_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }

    public function matches()
    {
        return $this->hasMany('App\Match');
    }

}
