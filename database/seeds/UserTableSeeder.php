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
        User::create([
            'name' => 'Maheo',
            'forname' => 'Maxime',
            'email' => 'imaxame@gmail.com',
            'birthday' => Carbon::create(1996, 9, 20)->format('d/m/Y'),
            'tshirt_size' => 'M',
            'gender' => 'man',
            'address' => '3 rue du Maréchal Lyautey',
            'phone' => '0604073165',
            'license' => '',
            'active' => true,
            'state' => 'active',
            'lectra_relationship' => 'child',
            'newsletter' => true,
            'avatar' => false,
            'role' => 'admin',
            'first_connect' => false,
            'password' => bcrypt('mmmmmm'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->save();
    }

}