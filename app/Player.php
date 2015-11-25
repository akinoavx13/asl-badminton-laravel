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

    public function scopeWithSeason($query, $season_id)
    {
        $query->where('season_id', $season_id);
    }

    public function scopeWithUser($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    /******************/
    /*      Scope     */
    /******************/

    public function scopeOrderByForname($query)
    {
        $query->with('user')
            ->join('users', 'users.id', '=', 'players.user_id')
            ->orderBy('users.forname', 'asc');
    }

    public function totalPrice()
    {
        $price = 0;

        //calculate t-shirt but not corpo and competition player
        if ($this->hasTShirt(true) && ! $this->hasFormula('corpo') && ! $this->hasFormula('competition'))
        {
            $price += 25;
        }

        //calculate leisure formula
        if ($this->hasFormula('leisure'))
        {
            $price += $this->user->hasLectraRelation('external') ? 100 : 10;
        }

        //calculate fun formula
        if ($this->hasFormula('fun'))
        {
            $price += $this->user->hasLectraRelation('external') ? 100 : 20;
        }

        //calculate performance formula
        if ($this->hasFormula('performance'))
        {
            $price += $this->user->hasLectraRelation('external') ? 100 : 30;
        }

        //calculate corpo formula
        if ($this->hasFormula('corpo'))
        {
            $price += $this->user->hasLectraRelation('external') ? 100 : 40;
        }

        //calculate competition formula
        if ($this->hasFormula('competition'))
        {
            $price += $this->user->hasLectraRelation('external') ? 200 : 80;
        }

        return $price;
    }

    public function hasTShirt($t_shirt)
    {
        return $this->t_shirt === $t_shirt;
    }

    /******************/
    /*    Functions   */
    /******************/

    public function hasFormula($formula)
    {
        return $this->formula === $formula;
    }

}
