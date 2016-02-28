<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';

    protected $fillable = [
        'first_set_first_team',
        'first_set_second_team',
        'second_set_first_team',
        'second_set_second_team',
        'third_set_first_team',
        'third_set_second_team',
        'display',
        'first_team_id',
        'second_team_id',
        'my_wo',
        'his_wo',
        'unplayed',
        'first_team_win',
        'second_team_win',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'display' => 'boolean',
        'my_wo'    => 'boolean',
        'his_wo'   => 'boolean',
        'unplayed' => 'boolean',
        'first_team_win' => 'boolean',
        'second_team_win' => 'boolean',
    ];

    public function firstTeam()
    {
        return $this->belongsTo('App\Team');
    }

    public function secondTeam()
    {
        return $this->belongsTo('App\Team');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /******************/
    /*      Has       */
    /******************/

    public function hasDisplay($display)
    {
        return $this->display === $display;
    }

    public function hasMyWo($my_wo)
    {
        return $this->my_wo === $my_wo;
    }

    public function hasHisWo($his_wo)
    {
        return $this->his_wo === $his_wo;
    }

    public function hasUnplayed($unplayed)
    {
        return $this->unplayed === $unplayed;
    }

    public function hasFirstTeamWin($first_team_win)
    {
        return $this->first_team_win === $first_team_win;
    }

    public function hasSecondTeamWin($second_team_win)
    {
        return $this->second_team_win === $second_team_win;
    }

    /******************/
    /*     Scope      */
    /******************/

    public function scopeAllScoresDoubleOrMixteInSelectedPool($query, $pool_id)
    {
        $query->join('teams as firstTeam', 'firstTeam.id', '=', 'scores.first_team_id')
            ->join('players as playerOneFirstTeam', 'playerOneFirstTeam.id', '=', 'firstTeam.player_one')
            ->join('users as userOneFirstTeam', 'userOneFirstTeam.id', '=', 'playerOneFirstTeam.user_id')
            ->join('players as playerTwoFirstTeam', 'playerTwoFirstTeam.id', '=', 'firstTeam.player_two')
            ->join('users as userTwoFirstTeam', 'userTwoFirstTeam.id', '=', 'playerTwoFirstTeam.user_id')
            ->join('teams as secondTeam', 'secondTeam.id', '=', 'scores.second_team_id')
            ->join('players as playerOneSecondTeam', 'playerOneSecondTeam.id', '=', 'secondTeam.player_one')
            ->join('users as userOneSecondTeam', 'userOneSecondTeam.id', '=', 'playerOneSecondTeam.user_id')
            ->join('players as playerTwoSecondTeam', 'playerTwoSecondTeam.id', '=', 'secondTeam.player_two')
            ->join('users as userTwoSecondTeam', 'userTwoSecondTeam.id', '=', 'playerTwoSecondTeam.user_id')
            ->join('championship_rankings as rankingFirstTeam', 'rankingFirstTeam.team_id', '=', 'firstTeam.id')
            ->join('championship_rankings as rankingSecondTeam', 'rankingSecondTeam.team_id', '=', 'secondTeam.id')
            ->where('rankingFirstTeam.championship_pool_id', $pool_id)
            ->where('rankingSecondTeam.championship_pool_id', $pool_id);
    }

    public function scopeAllScoresSimpleInSelectedPool($query, $pool_id)
    {
        $query->join('teams as firstTeam', 'firstTeam.id', '=', 'scores.first_team_id')
            ->join('players as playerFirstTeam', 'playerFirstTeam.id', '=', 'firstTeam.player_one')
            ->join('users as userFirstTeam', 'userFirstTeam.id', '=', 'playerFirstTeam.user_id')
            ->join('teams as secondTeam', 'secondTeam.id', '=', 'scores.second_team_id')
            ->join('players as playerSecondTeam', 'playerSecondTeam.id', '=', 'secondTeam.player_one')
            ->join('users as userSecondTeam', 'userSecondTeam.id', '=', 'playerSecondTeam.user_id')
            ->join('championship_rankings as rankingFirstTeam', 'rankingFirstTeam.team_id', '=', 'firstTeam.id')
            ->join('championship_rankings as rankingSecondTeam', 'rankingSecondTeam.team_id', '=', 'secondTeam.id')
            ->where('rankingFirstTeam.championship_pool_id', $pool_id)
            ->where('rankingSecondTeam.championship_pool_id', $pool_id);
    }

}
