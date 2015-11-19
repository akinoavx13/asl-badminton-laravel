<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

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
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['created_at', 'updated_at', 'birthday'];


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

    public function getBirthdayAttribute($birthday)
    {
        $date = Carbon::createFromFormat('Y-m-d', $birthday);

        return $date->format('d/m/Y');
    }

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $birthday)->format('Y-m-d');
    }
}
