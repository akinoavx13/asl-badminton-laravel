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
        'enable',
    ];

    protected $casts = [
        'simple'      => 'boolean',
        'double'      => 'boolean',
        'enable'       => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        $string = $this->playerOne->__toString();
        if($this->playerTwo !== null)
        {
            $string .= ' & <br>' . $this->playerTwo->__toString();
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

    /******************/
    /*      Scope     */
    /******************/

    public function scopeSimple($query, $player, $activeSeason)
    {
        $query->where('player_one', $player->id)
            ->whereNull('player_two')
            ->where('double', false)
            ->where('mixte', false)
            ->where('season_id', $activeSeason->id);
    }

}
