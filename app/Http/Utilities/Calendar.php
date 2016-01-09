<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 09/01/2016
 * Time: 18:19
 */

namespace App\Http\Utilities;


use Carbon\Carbon;
use Jenssegers\Date\Date;

class Calendar
{

    public static function getAllDaysMonth()
    {
        $firstDayMonth = new Date('first day of this month');

        $daysNumber = $firstDayMonth->daysInMonth;

        $allDays = [];

        for($dayNumber = 1; $dayNumber <= $daysNumber; $dayNumber++)
        {
            $date = Date::createFromDate($firstDayMonth->year, $firstDayMonth->month, $dayNumber);
            if(!$date->isWeekend())
            {
                $allDays[] = Date::createFromDate($firstDayMonth->year, $firstDayMonth->month, $dayNumber);
            }
        }

        return $allDays;
    }

}