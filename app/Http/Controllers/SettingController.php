<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SettingUpdateRequest;
use App\Setting;

class SettingController extends Controller
{
    public static function routes($router)
    {
        //paterns
        $router->pattern('setting_id', '[0-9]+');

        //setting list
        $router->get('/index', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SettingController@index',
            'as'         => 'setting.index',
        ]);

        //setting store
        $router->get('/store', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SettingController@store',
            'as'         => 'setting.store',
        ]);

        //setting store
        $router->post('/update/{setting_id}', [
            'middleware' => ['auth', 'admin'],
            'uses'       => 'SettingController@update',
            'as'         => 'setting.update',
        ]);
    }

    public function index()
    {
        $setting = Setting::first();

        return view('setting.index', compact('setting'));
    }

    public function store()
    {
        if (Setting::all()->count() <= 0)
        {
            Setting::create([
                'cestas_sport_email' => '',
                'web_site_email'     => '',
                'web_site_name'      => '',
                'cc_email'           => '',
                'can_buy_t_shirt'    => false,
                'can_enroll'         => false,
            ]);

            return redirect()->route('setting.index')->with('success', "Les paramètres sont crées !");
        }

        return redirect()->route('setting.index')->with('error', "Les paramètres existe déjà !");
    }

    public function update(SettingUpdateRequest $request, $setting_id)
    {
        $setting = Setting::findOrFail($setting_id);

        $setting->update([
            'cestas_sport_email' => $request->cestas_sport_email,
            'web_site_email'     => $request->web_site_email,
            'web_site_name'      => $request->web_site_name,
            'cc_email'           => $request->cc_email,
            'can_buy_t_shirt'    => $request->can_buy_t_shirt,
            'can_enroll'         => $request->can_enroll,
        ]);

        return redirect()->route('setting.index')->with('success', "Les paramètres sont modifiés !");
    }
}
