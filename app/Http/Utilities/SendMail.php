<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 09/01/2016
 * Time: 18:19
 */

namespace App\Http\Utilities;


use App\Helpers;
use Mail;
use App\Period;
use App\Season;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class SendMail
{

    public static function send($user, $template, $data, $subject)
    {
        if (Helpers::getInstance()->canSendMail())
        {
            if($user !== null)
            {
                Mail::send('emails.' . $template, $data, function ($message) use ($user, $subject)
                {
                    $message->from(Helpers::getInstance()->fromAddressMail(), Helpers::getInstance()->fromNameMail());
                    $message->to($user->email, $user)
                        ->subject($subject)->cc(Helpers::getInstance()->ccMail());
                });
            }
        }
    }

}