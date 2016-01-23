<?php

use App\Court;
use Illuminate\Database\Seeder;

class CourtTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 7; $i++)
        {
            Court::create([
                'type'   => $i <= 4 ? 'simple' : 'double',
                'number' => $i,
            ]);
        }
    }
}
