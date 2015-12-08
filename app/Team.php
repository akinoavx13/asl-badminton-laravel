<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'player_one',
        'player_two',
        'season_id',
        'simple',
        'double',
        'mixte',
    ];

    protected $casts = [
        'simple'      => 'boolean',
        'double'      => 'boolean',
        'mixte'       => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        $string = $this->playerOne->__toString();
        if($this->playerTwo !== null)
        {
            $string .= $this->playerTwo->__toString();
        }
        return $string;
    }

    public function playerOne()
    {
        return $this->belongsTo('App\Player', 'player_one');
    }

    public function playerTwo()
    {
        return $this->belongsTo('App\Player', 'player_two');
    }

}
