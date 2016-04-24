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
                                $message->to($setting->cestas_sport_email,
                                    "Cestas Sports")->subject($subject)->cc(Helpers::getInstance()->ccMail());
                            }
                        }
                        else
                        {
                            if (count($user) > 1)
                            {
                                //mail resa
                                if ($attachFile !== null)
                                {
                                    $message->to($user)->subject($subject);
                                }
                                else
                                {
                                    $message->to($user)->subject($subject)->cc(Helpers::getInstance()->ccMail());
                                }
                            }
                            elseif (count($user) == 1)
                            {
                                //mail resa
                                if ($attachFile !== null)
                                {
                                    $message->to($user->email, $user)->subject($subject);
                                }
                                else
                                {
                                    $message->to($user->email, $user)->subject($subject)->cc(Helpers::getInstance()->ccMail());
                                }
                            }

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