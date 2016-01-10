<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'player_one',
        'player_two',
        'season_id',
        'simple_man',
        'simple_woman',
        'double_man',
        'double_woman',
        'mixte',
        'enable',
    ];

    protected $casts = [
        'simple_man'   => 'boolean',
        'simple_woman' => 'boolean',
        'double_man'   => 'boolean',
        'double_woman' => 'boolean',
        'mixte'        => 'boolean',
        'enable'       => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        $string = $this->playerOne->__toString();
        if ($this->playerTwo !== null)
        {
            $string .= ' & ' . $this->playerTwo->__toString();
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

    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    /******************/
    /*      Scope     */
    /******************/


    public function scopeAllMySimpleTeams($query, $gender, $player_id, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.simple_' . $gender, true)
            ->where('teams.player_one', $player_id)
            ->whereNull('teams.player_two');
    }

    public function scopeAllSimpleTeamsWithoutMe($query, $gender, $player_id, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.simple_' . $gender, true)
            ->where('teams.player_one', '<>', $player_id)
            ->whereNull('teams.player_two');
    }

    public function scopeAllMyDoubleOrMixteActiveTeams($query, $type, $gender, $player_id, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
            ->where('teams.player_one', $player_id)
            ->where('teams.enable', true)
            ->orWhere(function ($query) use ($type, $gender, $player_id, $season_id)
            {
                $query->where('teams.season_id', $season_id)
                    ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
                    ->where('teams.player_two', $player_id)
                    ->where('teams.enable', true);
            });
    }

    public function scopeAllDoubleOrMixteActiveTeams($query, $type, $gender, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
            ->where('teams.enable', true)
            ->orWhere(function ($query) use ($type, $gender, $season_id)
            {
                $query->where('teams.season_id', $season_id)
                    ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
                    ->where('teams.enable', true);
            });
    }

    public function scopeMyDoubleOrMixteTeamsWithPartner($query, $type, $gender, $player_id, $partner_id, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
            ->where('teams.player_one', $player_id)
            ->where('teams.player_two', $partner_id)
            ->orWhere(function ($query) use ($type, $gender, $player_id, $partner_id, $season_id)
            {
                $query->where('teams.season_id', $season_id)
                    ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
                    ->where('teams.player_one', $partner_id)
                    ->where('teams.player_two', $player_id);
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

    public function hasEnable($enable)
    {
        return $this->enable === $enable;
    }

    /******************/
    /*     Function   */
    /******************/

}
