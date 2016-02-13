<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actuality extends Model
{
    protected $table = 'actualities';

    protected $fillable = [
        'user_id',
        'photo',
        'content',
        'title',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
