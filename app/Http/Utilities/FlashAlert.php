<?php
/**
 * Created by PhpStorm.
 * User: Maxime
 * Date: 14/11/2015
 * Time: 17:46
 */

namespace App\Http\Utilities;


class FlashAlert
{

    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    public function create($title, $message, $level, $key = 'flash_alert')
    {
        session()->flash($key, [
            'title' => $title,
            'message' => $message,
            'level' => $level,
        ]);
    }

    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    public function overlay($title, $message, $level = 'success')
    {
        return $this->create($title, $message, $level, 'flash_alert');
    }

}