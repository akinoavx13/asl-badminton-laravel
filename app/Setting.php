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
        'leisure_price',
        'fun_price',
        'performance_price',
        'corpo_price',
        'competition_price',
        'leisure_external_price',
        'fun_external_price',
        'performance_external_price',
        'corpo_external_price',
        'competition_external_price',
        't_shirt_price',
        'championship_simple_woman',
        'championship_double_woman',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'can_buy_t_shirt'           => 'boolean',
        'can_enroll'                => 'boolean',
        'championship_simple_woman' => 'boolean',
        'championship_double_woman' => 'boolean',
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

    public function hasChampionshipSimpleWoman($championshipSimpleWoman)
    {
        return $this->championship_simple_woman === $championshipSimpleWoman;
    }

    public function hasChampionshipDoubleWoman($championshipDoubleWoman)
    {
        return $this->championship_double_woman === $championshipDoubleWoman;
    }

}
