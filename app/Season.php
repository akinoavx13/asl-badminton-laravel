<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{

    protected $table = 'seasons';

    protected $fillable = [
        'name',
        'active',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function __toString()
    {
        return $this->name;
    }

    public function players()
    {
        return $this->hasMany('App\Player');
    }

    public function teams()
    {
        return $this->hasMany('App\Team');
    }

    public function periods()
    {
        return $this->hasMany('App\Period');
    }

    /******************/
    /*      Has       */
    /******************/

    public function hasActive($active)
    {
        return $this->active === $active;
    }

    /******************/
    /*      Scope     */
    /******************/

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

}
