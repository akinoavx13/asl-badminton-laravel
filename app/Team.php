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
        'enable',
    ];

    protected $casts = [
        'simple' => 'boolean',
        'double' => 'boolean',
        'mixte'  => 'boolean',
        'enable' => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        $string = $this->playerOne->__toString();
        if ($this->playerTwo !== null)
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
            ->where('simple', true)
            ->where('double', false)
            ->where('mixte', false)
            ->where('season_id', $activeSeason->id);
    }

    public function scopeDouble($query, $player, $activeSeason, $partner_id = null)
    {
        if ($partner_id === null)
        {
            $query->whereNotNull('player_two')
                ->where('player_one', $player->id)
                ->where('simple', false)
                ->where('double', true)
                ->where('mixte', false)
                ->where('season_id', $activeSeason->id)
                ->orWhere(function ($query) use ($player, $activeSeason)
                {
                    $query->whereNotNull('player_one')
                        ->where('player_two', $player->id)
                        ->where('simple', false)
                        ->where('double', true)
                        ->where('mixte', false)
                        ->where('season_id', $activeSeason->id);
                });
        }
        else
        {
            $query->where('player_two', $partner_id)
                ->where('player_one', $player->id)
                ->where('simple', false)
                ->where('double', true)
                ->where('mixte', false)
                ->where('season_id', $activeSeason->id)
                ->orWhere(function ($query) use ($player, $activeSeason, $partner_id)
                {
                    $query->where('player_one', $partner_id)
                        ->where('player_two', $player->id)
                        ->where('simple', false)
                        ->where('double', true)
                        ->where('mixte', false)
                        ->where('season_id', $activeSeason->id);
                });
        }
    }

    public function scopeMixte($query, $player, $activeSeason, $partner_id = null)
    {
        if ($partner_id === null)
        {
            $query->whereNotNull('player_two')
                ->where('player_one', $player->id)
                ->where('simple', false)
                ->where('double', false)
                ->where('mixte', true)
                ->where('season_id', $activeSeason->id)
                ->orWhere(function ($query) use ($player, $activeSeason)
                {
                    $query->whereNotNull('player_one')
                        ->where('player_two', $player->id)
                        ->where('simple', false)
                        ->where('double', false)
                        ->where('mixte', true)
                        ->where('season_id', $activeSeason->id);
                });
        }
        else
        {
            $query->where('player_two', $partner_id)
                ->where('player_one', $player->id)
                ->where('simple', false)
                ->where('double', false)
                ->where('mixte', true)
                ->where('season_id', $activeSeason->id)
                ->orWhere(function ($query) use ($player, $activeSeason, $partner_id)
                {
                    $query->where('player_one', $partner_id)
                        ->where('player_two', $player->id)
                        ->where('simple', false)
                        ->where('double', false)
                        ->where('mixte', true)
                        ->where('season_id', $activeSeason->id);
                });
        }
    }

    public function scopeDoubleEnable($query, $player, $activeSeason)
    {
        $query->whereNotNull('player_two')
            ->where('player_one', $player->id)
            ->where('simple', false)
            ->where('double', true)
            ->where('mixte', false)
            ->where('enable', true)
            ->where('season_id', $activeSeason->id)
            ->orWhere(function ($query) use ($player, $activeSeason)
            {
                $query->whereNotNull('player_one')
                    ->where('player_two', $player->id)
                    ->where('simple', false)
                    ->where('double', true)
                    ->where('mixte', false)
                    ->where('season_id', $activeSeason->id)
                    ->where('enable', true);
            });
    }

    public function scopeMixteEnable($query, $player, $activeSeason)
    {
        $query->whereNotNull('player_two')
            ->where('player_one', $player->id)
            ->where('simple', false)
            ->where('double', false)
            ->where('mixte', true)
            ->where('season_id', $activeSeason->id)
            ->where('enable', true)
            ->orWhere(function ($query) use ($player, $activeSeason)
            {
                $query->whereNotNull('player_one')
                    ->where('player_two', $player->id)
                    ->where('simple', false)
                    ->where('double', false)
                    ->where('mixte', true)
                    ->where('season_id', $activeSeason->id)
                    ->where('enable', true);
            });
    }

    /******************/
    /*       Has      */
    /******************/

    public function hasPlayerOne($playerOne)
    {
        return $this->player_one === $playerOne;
    }

    public function hasPlayerTwo($playerTwo)
    {
        return $this->player_two === $playerTwo;
    }

}
