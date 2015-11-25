<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
        ]);
    }
}
