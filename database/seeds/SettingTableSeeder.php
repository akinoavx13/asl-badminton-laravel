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
            'cestas_sport_email' => 'contact@cestas-sports.com',
            'web_site_email'     => 'contact@aslectra.com',
            'web_site_name'      => 'AS Lectra Badminton',
            'cc_email'           => 'c.maheo@lectra.com',
            'can_buy_t_shirt'    => true,
            'can_enroll'         => true,
        ]);
    }
}
