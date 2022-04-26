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

    public static function send($user, $template, $data, $subject, $toCestasSport = false, $attachFile = null)
    {
        if (Helpers::getInstance()->canSendMail())
        {
            if ($user !== null)
            {
                Mail::send('emails.' . $template, $data,
                    function ($message) use ($user, $subject, $toCestasSport, $attachFile)
                    {
                        $message->from(Helpers::getInstance()->fromAddressMail(),
                            Helpers::getInstance()->fromNameMail());

                        if ($toCestasSport)
                        {
                            $setting = Helpers::getInstance()->setting();

                            if ($setting !== null)
                            {
                                $message
                                ->to($setting->cestas_sport_email,"EPHOR")
                                ->subject($subject)
                                ->cc(Helpers::getInstance()->ccMail())
                                ->cc($user->email);
                            }
                        }
                        else
                        {
                            if (is_array($user) == true) $message->to($user)->subject($subject);
                            if (is_object($user) == true) $message->to($user->email, $user)->subject($subject);
                            //si pas attachement c'est un mail de resa on ne met pas le president en copie
                            if ($attachFile == null) $message->cc(Helpers::getInstance()->ccMail());
                        }

                        if ($attachFile !== null)
                        {
                            $message->attach($attachFile);
                        }
                    });
            }
        }
    }

}
