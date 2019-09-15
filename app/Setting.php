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
        'can_enroll_tournament',
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
        'volunteer_alert_flag',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'can_buy_t_shirt'           => 'boolean',
        'can_enroll'                => 'boolean',
        'can_enroll_tournament'     => 'boolean',
        'championship_simple_woman' => 'boolean',
        'championship_double_woman' => 'boolean',
        'volunteer_alert_flag'      => 'boolean',
        'monday'                    => 'boolean',
        'tuesday'                   => 'boolean',
        'wednesday'                 => 'boolean',
        'thursday'                  => 'boolean',
        'friday'                    => 'boolean',
        'saturday'                  => 'boolean',
        'sunday'                    => 'boolean',
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

    public function hasEnrollTournament($can_enroll_tournament)
    {
        return $this->can_enroll_tournament === $can_enroll_tournament;
    }

    public function hasChampionshipSimpleWoman($championshipSimpleWoman)
    {
        return $this->championship_simple_woman === $championshipSimpleWoman;
    }

    public function hasChampionshipDoubleWoman($championshipDoubleWoman)
    {
        return $this->championship_double_woman === $championshipDoubleWoman;
    }

    public function hasVolunteerAlertFlag($volunteer_alert_flag)
    {
        return $this->volunteer_alert_flag === $volunteer_alert_flag;
    }
    public function hasMonday($day)
    {
        return $this->monday === $day;
    }
    public function hasTuesday($day)
    {
        return $this->tuesday === $day;
    }
    public function hasWednesday($day)
    {
        return $this->wednesday === $day;
    }
    public function hasthursday($day)
    {
        return $this->thursday === $day;
    }
    public function hasFriday($day)
    {
        return $this->friday === $day;
    }
    public function hasSaturday($day)
    {
        return $this->saturday === $day;
    }
    public function hasSunday($day)
    {
        return $this->sunday === $day;
    }
    public function isOpenDay($day)
    {
        // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
        switch($day) {
            case 0:
                $result = $this->sunday;
                break;
            case 1:
                $result = $this->monday;
                break;
            case 2:
                $result = $this->tuesday;
                break;
            case 3:
                $result = $this->wednesday;
                break;
            case 4:
                $result = $this->thursday;
                break;
            case 5:
                $result = $this->friday;
                break;
            case 6:
                $result = $this->saturday;
                break;
            default:
                $result = false;
                break;
        }
        return $result;
    }

}
