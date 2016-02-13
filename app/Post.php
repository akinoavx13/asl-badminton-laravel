<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'score_id',
        'actuality_id',
        'photo',
        'content',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function score(){
        return $this->belongsTo('App\Score');
    }

    public function actuality(){
        return $this->belongsTo('App\Actuality');
    }
}
