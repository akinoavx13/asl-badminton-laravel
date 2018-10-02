<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Http\Requests;
use App\Http\Requests\SettingUpdateRequest;
use App\Setting;

/**
 * Manage settings
 *
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
    /**
     * @param $router
     */
    public static function routes($router)
    {
        //paterns
        $router->pattern('setting_id', '[0-9]+');

        //setting list
        $router->get('/index', [
            'uses' => 'SettingController@index',
            'as'   => 'setting.index',
        ]);

        //setting store
        $router->get('/store', [
            'uses' => 'SettingController@store',
            'as'   => 'setting.store',
        ]);

        //setting update
        $router->post('/update/{setting_id}', [
            'uses' => 'SettingController@update',
            'as'   => 'setting.update',
        ]);
    }

    /**
     * View setting, it's also the form to create or update settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $setting = Helpers::getInstance()->setting();

        return view('setting.index', compact('setting'));
    }

    /**
     * Store the setting if they are no setting created
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        if (Setting::all()->count() <= 0)
        {
            Setting::create([
                'cestas_sport_email'         => 'contact@cestas-sports.com',
                'web_site_email'             => 'contact@aslectra.com',
                'web_site_name'              => 'AS Lectra Badminton',
                'cc_email'                   => 'c.maheo@lectra.com',
                'can_buy_t_shirt'            => true,
                'can_enroll'                 => true,
                'leisure_price'              => 10,
                'fun_price'                  => 20,
                'performance_price'          => 30,
                'corpo_price'                => 40,
                'competition_price'          => 80,
                'leisure_external_price'     => 100,
                'fun_external_price'         => 100,
                'performance_external_price' => 100,
                'corpo_external_price'       => 100,
                'competition_external_price' => 200,
                't_shirt_price'              => 25,
                'championship_simple_woman'  => false,
                'championship_double_woman'  => false,
            ]);

            return redirect()->route('setting.index')->with('success', "Les paramètres sont créés !");
        }

        return redirect()->route('setting.index')->with('error', "Les paramètres existent déjà !");
    }

    /**
     * Update the setting
     *
     * @param SettingUpdateRequest $request
     * @param $setting_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingUpdateRequest $request, $setting_id)
    {
        $setting = Setting::findOrFail($setting_id);

        $setting->update([
            'cestas_sport_email'         => $request->cestas_sport_email,
            'web_site_email'             => $request->web_site_email,
            'web_site_name'              => $request->web_site_name,
            'cc_email'                   => $request->cc_email,
            'can_buy_t_shirt'            => $request->can_buy_t_shirt,
            'can_enroll'                 => $request->can_enroll,
            'leisure_price'              => $request->leisure_price,
            'fun_price'                  => $request->fun_price,
            'performance_price'          => $request->performance_price,
            'corpo_price'                => $request->corpo_price,
            'competition_price'          => $request->competition_price,
            'leisure_external_price'     => $request->leisure_external_price,
            'fun_external_price'         => $request->fun_external_price,
            'performance_external_price' => $request->performance_external_price,
            'corpo_external_price'       => $request->corpo_external_price,
            'competition_external_price' => $request->competition_external_price,
            't_shirt_price'              => $request->t_shirt_price,
            'championship_simple_woman'  => $request->championship_simple_woman,
            'championship_double_woman'  => $request->championship_double_woman,
        ]);

        return redirect()->route('setting.index')->with('success', "Les modifications sont bien prises en compte !");
    }
}
