<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 09/01/2016
 * Time: 18:19
 */

namespace App\Http\Utilities;


use App\Period;
use App\Season;
use App\Tournament;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Calendar
{

    public static function getAllDaysMonth()
    {

        $season = Season::active()->first();

        $lastDay = new Carbon('last day of this month');

        if($season !== null)
        {
            $period = Period::getCurrentPeriod();
            $tournament = Tournament::current($season->id)->first();

            if($period !== null)
            {
                $lastDay = $period->end;
            } else if($tournament !== null) {
                $lastDay = $tournament->end;
            }
        }

        $allDays = [];

        $day = Carbon::today();

        while($day <= $lastDay)
        {
            $date = Date::createFromDate($day->year, $day->month, $day->day);
            $day->addDay();
            if(!$date->isWeekend() && $date >= Date::today())
            {
                $allDays[] = $date;
            }
        }

        return $allDays;
    }

}