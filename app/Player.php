<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = [
        'formula',
        'ce_state',
        'gbc_state',
        'simple',
        'double',
        'mixte',
        'corpo_man',
        'corpo_woman',
        'corpo_mixte',
        't_shirt',
        'user_id',
        'season_id',
    ];

    protected $casts = [
        'simple'      => 'boolean',
        'double'      => 'boolean',
        'mixte'       => 'boolean',
        'corpo_man'   => 'boolean',
        'corpo_woman' => 'boolean',
        'corpo_mixte' => 'boolean',
        't_shirt'     => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        return $this->user->__toString();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    /******************/
    /*      Has       */
    /******************/

    public function hasSimple($simple)
    {
        return $this->simple === $simple;
    }

    public function hasDouble($double)
    {
        return $this->double === $double;
    }

    public function hasMixte($mixte)
    {
        return $this->mixte === $mixte;
    }

    public function hasFormula($formula)
    {
        return $this->formula === $formula;
    }

    public function hasCeState($ce_state)
    {
        return $this->ce_state === $ce_state;
    }

    public function hasGbcState($gbc_state)
    {
        return $this->gbc_state === $gbc_state;
    }

    public function hasCorpoMan($corpo_man)
    {
        return $this->corpo_man === $corpo_man;
    }

    public function hasCorpoWoman($corpo_woman)
    {
        return $this->corpo_woman === $corpo_woman;
    }

    public function hasCorpoMixte($corpo_mixte)
    {
        return $this->corpo_mixte === $corpo_mixte;
    }

    public function hasTShirt($t_shirt)
    {
        return $this->t_shirt === $t_shirt;
    }

    /******************/
    /*      Scope     */
    /******************/

    public function scopeWithSeason($query, $season_id)
    {
        $query->where('season_id', $season_id);
    }

    public function scopeWithUser($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    public function scopeOrderByForname($query)
    {
        $query->with('user')
            ->join('users', 'users.id', '=', 'players.user_id')
            ->orderBy('users.forname', 'asc');
    }

}
