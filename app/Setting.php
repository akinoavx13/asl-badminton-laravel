<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'cestas_sport_email',
        'web_site_email',
        'web_site_name',
        'cc_email',
        'can_buy_t_shirt',
        'can_enroll',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'can_buy_t_shirt' => 'boolean',
        'can_enroll'      => 'boolean',
    ];

    /******************/
    /*      Has       */
    /******************/

    public function hasBuyTShirt($can_buy_t_shirt)
    {
        return $this->can_buy_t_shirt === $can_buy_t_shirt;
    }

    public function hasEnroll($can_enroll)
    {
        return $this->can_enroll === $can_enroll;
    }

}
