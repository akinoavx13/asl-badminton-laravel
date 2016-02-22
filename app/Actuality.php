<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic;

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
            return "/img/actualities/{$this->id}.jpg";
        }

        return false;
    }

    public function setPhotoAttribute($photo)
    {
        if (is_object($photo) && $photo->isValid())
        {

            $image = ImageManagerStatic::make($photo);

            if ($image->width() > 200 && $image->height() > 200)
            {
                $max = $image->width() > $image->height() ? 'width' : 'height';

                if ($max == 'width')
                {
                    $image->resize(200, null, function ($constraint)
                    {
                        $constraint->aspectRatio();
                    });
                }
                else
                {
                    $image->resize(null, 200, function ($constraint)
                    {
                        $constraint->aspectRatio();
                    });
                }
            }
            elseif($image->width() < 200 && $image->height() > 200)
            {
                $image->resize(null, 200, function ($constraint)
                {
                    $constraint->aspectRatio();
                });
            }
            elseif($image->width() > 200 && $image->height() < 200)
            {
                $image->resize(200, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                });
            }

            $image->save(public_path() . "/img/actualities/{$this->id}.jpg");
            $this->attributes['photo'] = 1;
        }
    }
}
