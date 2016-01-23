<?php

use App\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeSlot::create([
            'start' => '12:00',
            'end'   => '12:30',
        ]);

        TimeSlot::create([
            'start' => '12:30',
            'end'   => '13:00',
        ]);
    }
}
