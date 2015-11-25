<?php

use App\Player;
use Illuminate\Database\Seeder;

class PlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 11; $i++)
        {
            Player::create([
                'formula'     => 'fun',
                'ce_state'    => 'contribution_payable',
                'gbc_state'   => 'non_applicable',
                'simple'      => true,
                'double'      => true,
                'mixte'       => true,
                'corpo_man'   => false,
                'corpo_woman' => false,
                'corpo_mixte' => false,
                't_shirt'     => true,
                'season_id'   => 1,
                'user_id'     => $i,
            ]);
        }
    }
}
