<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rope extends Model
{
    protected $table = 'ropes';

    protected $fillable = [
        'user_id',
        'rest',
        'fill',
        'tension',
        'comment',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'fill' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /******************/
    /*      Has       */
    /******************/

    public function hasFill($fill)
    {
        return $this->fill === $fill;
    }
}
