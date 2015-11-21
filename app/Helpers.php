<?php

namespace App;

class Helpers
{

    private static $instance;
    private $setting;

    public function __construct()
    {
        $this->setting = Setting::first();
    }

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function flash($title = null, $message = null)
    {
        $flash = app('App\Http\Utilities\FlashAlert');

        if (func_num_args() == 0)
        {
            return $flash;
        }

        return $flash->info($title, $message);
    }

    public function canSendMail()
    {
        return env('APP_ENV') === 'prod' || env('APP_ENV') === 'local';
    }

    public function fromAddressMail()
    {
        return $this->setting->web_site_email;
    }

    public function fromNameMail()
    {
        return $this->setting->web_site_name;
    }

    public function ccMail()
    {
        return $this->setting->cc_email;
    }
}