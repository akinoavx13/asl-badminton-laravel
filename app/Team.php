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

    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    /******************/
    /*      Scope     */
    /******************/

    public function scopeListPartner($query, $type, $gender)
    {
        $query->join('seasons', 'teams.season_id', '=', 'seasons.id')
            ->join('players', 'players.id', '=', 'teams.player_one')
            ->join('users', 'users.id', '=', 'players.user_id')
            ->where('seasons.active', true)
            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
            ->where('teams.enable', true)
            ->where('users.gender', $gender)
            ->whereNull('teams.player_two')
            ->orderBy('users.forname', 'asc');
    }

    public function scopeMyTeamSimple($query, $gender, $player_id)
    {
        $query->join('seasons', 'seasons.id', '=', 'teams.season_id')
            ->where('seasons.active', true)
            ->where('teams.enable', true)
            ->where('teams.simple_' . $gender, true)
            ->where('teams.player_one', $player_id)
            ->whereNull('teams.player_two');
    }

    public function scopeMyTeamDoubleOrMixte($query, $type, $gender, $player_id)
    {
        $query->join('seasons', 'seasons.id', '=', 'teams.season_id')
            ->where('seasons.active', true)
            ->where('teams.enable', true)
            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
            ->where('teams.player_one', $player_id)
            ->orWhere(function ($query) use ($type, $gender, $player_id)
            {
                $query->where('seasons.active', true)
                    ->where('teams.enable', true)
                    ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
                    ->where('teams.player_two', $player_id);
            });
    }

    public function scopeAllMySimpleTeams($query, $gender, $player_id, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.simple_' . $gender, true)
            ->where('teams.player_one', $player_id)
            ->whereNull('teams.player_two');
    }

    public function scopeAllMyDoubleOrMixteTeams($query, $type, $gender, $player_id, $season_id)
    {
        $query->where('teams.season_id', $season_id)
            ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
            ->where('teams.player_one', $player_id)
            ->orWhere(function ($query) use ($type, $gender, $player_id, $season_id)
            {
                $query->where('teams.season_id', $season_id)
                    ->where('teams.' . ($type == 'mixte' ? 'mixte' : $type . '_' . $gender), true)
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

    public static function listParnterAvailable($type, $gender, $player_id = null)
    {

        if ($player_id !== null)
        {
            //je recherche mon équipe de $type dans laquelle je suis pour cette saison
            $myTeam[$type] = Team::select('teams.player_one', 'teams.player_two')
                ->myTeamDoubleOrMixte($type, $gender, $player_id)
                ->first();

            //si j'ai une équipe de $type, alors je la met en premier dans le champ select
            if ($myTeam[$type] !== null)
            {
                //si je suis le premier joueur alors il faut prendre les valeurs du second joueur dans le select
                if ($myTeam[$type]->player_one === $player_id)
                {
                    $listPartner[$myTeam[$type]->player_two] = $myTeam[$type]->playerTwo->user->__toString();
                }
                //sinon si je suis le deuxime joueur, il faut mettre le premier joueur dans le select
                else
                {
                    if ($myTeam[$type]->player_two === $player_id)
                    {
                        $listPartner[$myTeam[$type]->player_one] = $myTeam[$type]->playerOne->user->__toString();
                    }
                }
            }
        }

        $listPartner['search'] = 'En recherche';

        $listParnterAvailable = Team::select('teams.player_one')
            ->distinct()
            ->listPartner($type, $gender)
            ->get();

        foreach ($listParnterAvailable as $parnterAvailable)
        {
            $listPartner[$parnterAvailable->player_one] = $parnterAvailable->playerOne->user->__toString();
        }

        return $listPartner;
    }

}
