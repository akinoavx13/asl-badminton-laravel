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
        $this->call(SeasonTableSeeder::class);
        $this->call(PlayerTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(CourtTableSeeder::class);
        $this->call(TimeSlotTableSeeder::class);

        Model::reguard();
    }
}
