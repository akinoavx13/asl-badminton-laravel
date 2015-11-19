<?php

namespace App;

use Carbon\Carbon;
use File;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Intervention\Image\ImageManagerStatic;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'forname',
        'email',
        'birthday',
        'tshirt_size',
        'gender',
        'address',
        'phone',
        'license',
        'active',
        'state',
        'lectra_relationship',
        'newsletter',
        'avatar',
        'role',
        'password',
        'ending_holiday',
        'ending_injury',
        'token_first_connection',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($instance)
        {
            if ($instance->avatar)
            {
                File::delete(public_path() . $instance->avatar);
            }

            return true;
        });
    }

    public function __toString()
    {
        return ucfirst($this->forname) . ' ' . ucfirst($this->name);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasOwner($user_id)
    {
        return $this->id === $user_id;
    }

    public function hasGender($gender)
    {
        return $this->gender === $gender;
    }

    public function hasNewsletter($newsletter)
    {
        return $this->newsletter === $newsletter;
    }

    public function hasActive($active)
    {
        return $this->active === $active;
    }

    public function hasState($state)
    {
        return $this->state === $state;
    }

    public function hasLectraRelation($lectraRelationShip)
    {
        return $this->lectra_relationship === $lectraRelationShip;
    }

    public function hasFirstConnection($firstConnection)
    {
        return $this->first_connect === $firstConnection;
    }

    public function getBirthdayAttribute($birthday)
    {
        $date = Carbon::createFromFormat('Y-m-d', $birthday);

        return $date->format('d/m/Y');
    }

    public function getBirthday()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['birthday']);
    }

    public function getEndingInjury()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['ending_injury']);
    }

    public function getEndingHoliday()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['ending_holiday']);
    }

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $birthday)->format('Y-m-d');
    }

    public function getEndingInjuryAttribute($ending_injury)
    {
        $date = Carbon::createFromFormat('Y-m-d', $ending_injury);

        return $date->format('d/m/Y');
    }

    public function setEndingInjuryAttribute($ending_injury)
    {
        $this->attributes['ending_injury'] = Carbon::createFromFormat('d/m/Y', $ending_injury)->format('Y-m-d');
    }

    public function getEndingHolidayAttribute($ending_holiday)
    {
        $date = Carbon::createFromFormat('Y-m-d', $ending_holiday);

        return $date->format('d/m/Y');
    }

    public function setEndingHolidayAttribute($ending_holiday)
    {
        $this->attributes['ending_holiday'] = Carbon::createFromFormat('d/m/Y', $ending_holiday)->format('Y-m-d');
    }

    public function setAvatarAttribute($avatar)
    {
        if (is_object($avatar) && $avatar->isValid())
        {
            ImageManagerStatic::make($avatar)->fit(200)->save(public_path() . "/img/avatars/{$this->id}.jpg");
            $this->attributes['avatar'] = 1;
        }
    }

    public function getAvatarAttribute()
    {
        if ($this->hasAvatar("1"))
        {
            return "/img/avatars/{$this->id}.jpg";
        }

        return false;
    }

    public function hasAvatar($avatar)
    {
        return $this->attributes['avatar'] === $avatar;
    }
}
