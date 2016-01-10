<?php

namespace App;

use Auth;

class Helpers
{

    private static $instance;
    private $setting;
    private $auth;
    private $myPlayer;

    public function __construct()
    {
        if ($this->setting === null)
        {
            $this->setting = Setting::first();
        }

        if ($this->auth === null)
        {
            $this->auth = Auth::user();
        }

        if ($this->myPlayer === null && $this->auth !== null)
        {
            $this->myPlayer = User::select('players.*')->myPlayerInActiveSeason($this->auth->id)->first();
        }
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

    public function setting()
    {
        return $this->setting;
    }

    public function auth()
    {
        return $this->auth;
    }

    public function myPlayer()
    {
        return $this->myPlayer;
    }

    public function getTeamName($fornameOne, $nameOne, $fornameTwo = null, $nameTwo = null)
    {
        if($fornameTwo === null && $nameTwo === null)
        {
            return $fornameOne . ' ' . $nameOne;
        }
        else
        {
            return $fornameOne . ' ' . $nameOne . ' & ' . $fornameTwo . ' ' . $nameTwo;
        }
    }
}