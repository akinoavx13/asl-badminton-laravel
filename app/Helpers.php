<?php
/**
 * Created by PhpStorm.
 * User: Maxime
 * Date: 14/11/2015
 * Time: 17:45
 */

function flash($title = null, $message = null)
{
    $flash = app('App\Http\Utilities\FlashAlert');

    if (func_num_args() == 0)
    {
        return $flash;
    }

    return $flash->info($title, $message);
}

function canSendMail()
{
    return env('APP_ENV') === 'prod' || env('APP_ENV') === 'local';
}

function fromAddressMail()
{
    return env('MAIL_FROM_ADDRESS');
}

function fromNameMail()
{
    return env('MAIL_FROM_NAME');
}