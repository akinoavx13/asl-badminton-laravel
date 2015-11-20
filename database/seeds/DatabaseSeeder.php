<?php

use database\seeds\UserTableSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);

        factory(App\User::class, 10)->create()->each(function ($user)
        {
            $user->players()->save(factory(App\Player::class)->make());
        });

        Model::reguard();
    }
}
