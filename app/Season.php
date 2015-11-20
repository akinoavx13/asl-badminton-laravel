<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seasons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function __toString()
    {
        return $this->name;
    }

    public function hasActive($active)
    {
        return $this->active === $active;
    }

}
