<?php

use App\Player;
use Illuminate\Database\Seeder;

class PlayerTableSeeder extends Seeder
{

    private static $players = [];

    public function __construct()
    {
        self::$players[1] = ['performance', '0', '1', '1', '0', '0', '0'];
        self::$players[2] = ['fun', '0', '0', '0', '0', '0', '0'];
        self::$players[3] = ['performance', '0', '1', '1', '0', '0', '0'];
        self::$players[4] = ['fun', '1', '1', '1', '0', '0', '0'];
        self::$players[5] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[6] = ['corpo', '1', '1', '1', '1', '0', '1'];
        self::$players[7] = ['performance', '1', '1', '0', '0', '0', '0'];
        self::$players[8] = ['corpo', '1', '1', '0', '1', '0', '1'];
        self::$players[9] = ['performance', '1', '1', '1', '0', '0', '0'];
        self::$players[10] = ['fun', '1', '0', '0', '0', '0', '0'];
        self::$players[11] = ['corpo', '1', '1', '0', '0', '0', '0'];
        self::$players[12] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[13] = ['corpo', '1', '1', '1', '0', '1', '1'];
        self::$players[14] = ['performance', '0', '1', '0', '0', '0', '0'];
        self::$players[15] = ['fun', '0', '1', '0', '0', '0', '0'];
        self::$players[16] = ['competition', '1', '1', '1', '1', '0', '1'];
        self::$players[17] = ['fun', '1', '0', '0', '0', '0', '0'];
        self::$players[18] = ['performance', '0', '1', '1', '0', '0', '0'];
        self::$players[19] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[20] = ['competition', '1', '1', '1', '1', '0', '1'];
        self::$players[21] = ['performance', '0', '0', '1', '0', '0', '0'];
        self::$players[22] = ['fun', '1', '1', '1', '0', '0', '0'];
        self::$players[23] = ['performance', '0', '1', '1', '0', '0', '0'];
        self::$players[24] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[25] = ['fun', '1', '0', '1', '0', '0', '0'];
        self::$players[26] = ['performance', '1', '1', '0', '0', '0', '0'];
        self::$players[27] = ['fun', '0', '0', '1', '0', '0', '0'];
        self::$players[28] = ['competition', '1', '1', '1', '0', '1', '1',];
        self::$players[29] = ['leisure', '0', '0', '1', '0', '0', '0'];
        self::$players[30] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[31] = ['performance', '0', '0', '0', '0', '0', '0'];
        self::$players[32] = ['corpo', '1', '1', '1', '1', '0', '1'];
        self::$players[33] = ['fun', '0', '0', '1', '0', '0', '0'];
        self::$players[34] = ['performance', '1', '1', '0', '0', '0', '0'];
        self::$players[35] = ['fun', '0', '1', '1', '0', '0', '0'];
        self::$players[36] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[37] = ['performance', '0', '0', '1', '0', '0', '0'];
        self::$players[38] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[39] = ['fun', '0', '0', '1', '0', '0', '0'];
        self::$players[40] = ['competition', '1', '1', '1', '0', '1', '1'];
        self::$players[41] = ['fun', '1', '0', '1', '0', '0', '0'];
        self::$players[42] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[43] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[44] = ['performance', '1', '1', '0', '0', '0', '0'];
        self::$players[45] = ['corpo', '1', '1', '1', '0', '1', '1'];
        self::$players[46] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[47] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[48] = ['competition', '0', '0', '0', '1', '0', '1'];
        self::$players[49] = ['fun', '0', '1', '0', '0', '0', '0'];
        self::$players[50] = ['performance', '1', '0', '0', '0', '0', '0'];
        self::$players[51] = ['leisure', '0', '0', '0', '0', '0', '0'];
        self::$players[52] = ['competition', '1', '1', '1', '1', '0', '1'];
        self::$players[53] = ['corpo', '1', '1', '1', '1', '1', '0'];
        self::$players[54] = ['fun', '0', '1', '0', '0', '0', '0'];
        self::$players[55] = ['fun', '0', '0', '1', '0', '0', '0'];
        self::$players[56] = ['fun', '1', '0', '1', '0', '0', '0'];
        self::$players[57] = ['performance', '1', '0', '0', '0', '0', '0'];
        self::$players[58] = ['fun', '1', '0', '0', '0', '0', '0'];
        self::$players[59] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[60] = ['performance', '1', '0', '0', '0', '0', '0'];
        self::$players[61] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[62] = ['fun', '1', '1', '0', '0', '0', '0'];
        self::$players[63] = ['performance', '1', '0', '1', '0', '0', '0'];
        self::$players[64] = ['performance', '1', '0', '0', '0', '0', '0'];
        self::$players[65] = ['performance', '1', '1', '0', '0', '0', '0'];
        self::$players[66] = ['leisure', '1', '0', '0', '0', '0', '0'];
        self::$players[67] = ['performance', '0', '0', '1', '0', '0', '0'];
        self::$players[68] = ['corpo', '1', '0', '0', '1', '0', '1'];
        self::$players[69] = ['competition', '1', '1', '1', '1', '0', '1'];
        self::$players[70] = ['competition', '1', '1', '1', '1', '0', '1'];
        self::$players[71] = ['fun', '0', '0', '0', '0', '0', '0'];
        self::$players[72] = ['leisure', '0', '0', '0', '0', '0', '0'];
    }

    public function run()
    {

        foreach (self::$players as $id => $player)
        {
            Player::create([
                'formula'     => $player[0],
                'ce_state'    => 'contribution_payable',
                'gbc_state'   => $player[0] === 'competition' ? 'entry_must' : 'non_applicable',
                'simple'      => $player[1],
                'double'      => $player[2],
                'mixte'       => $player[3],
                'corpo_man'   => $player[4],
                'corpo_woman' => $player[5],
                'corpo_mixte' => $player[6],
                't_shirt'     => true,
                'season_id'   => 2,
                'user_id'     => $id,
            ]);
        }
    }
}
