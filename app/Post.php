<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic;

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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function score()
    {
        return $this->belongsTo('App\Score');
    }

    public function actuality()
    {
        return $this->belongsTo('App\Actuality');
    }

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($instance)
        {
            if ($instance->photo)
            {
                unlink(public_path() . $instance->photo);
            }

            return true;
        });
    }

    public function getPhotoAttribute($photo)
    {
        if ($photo)
        {
            return "/img/posts/{$this->id}.jpg";
        }

        return false;
    }

    public function setPhotoAttribute($photo)
    {
        if (is_object($photo) && $photo->isValid())
        {
            ImageManagerStatic::make($photo)->fit(200)->save(public_path() . "/img/posts/{$this->id}.jpg");
            $this->attributes['photo'] = 1;
        }
    }
}
