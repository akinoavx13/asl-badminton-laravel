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

    /******************/
    /*      Has       */
    /******************/

    public function hasActive($active)
    {
        return $this->active === $active;
    }

}
