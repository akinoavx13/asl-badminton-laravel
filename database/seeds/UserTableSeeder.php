<?php
/**
 * Created by PhpStorm.
 * User: Maxime
 * Date: 14/11/2015
 * Time: 17:10
 */

namespace database\seeds;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        for ($i = 0; $i <= 10; $i++)
        {
            User::create([
                'name'    => $i == 0 ? 'Maheo' : 'Maheo' . $i,
                'forname' => $i == 0 ? 'Maxime' : 'Maxime' . $i,
                'email'   => $i == 0 ? 'imaxame@gmail.com' : 'imaxame' . $i . '@gmail.com',
                'birthday'            => Carbon::create(1996, 9, 20)->format('d/m/Y'),
                'tshirt_size'         => 'M',
                'gender'              => 'man',
                'address'             => '3 rue du Maréchal Lyautey',
                'phone'               => '0604073165',
                'license'             => null,
                'active'              => true,
                'state'               => 'active',
                'ending_holiday'      => Carbon::now()->format('d/m/Y'),
                'ending_injury'       => Carbon::now()->format('d/m/Y'),
                'lectra_relationship' => 'child',
                'newsletter'          => true,
                'avatar'              => false,
                'role'    => $i == 0 ? 'admin' : 'user',
                'first_connect'       => false,
                'password'            => bcrypt('mmmmmm'),
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
            ]);
        }
    }

}