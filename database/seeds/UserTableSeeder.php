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

    private static $user = [];

    public function __construct()
    {
        self::$user[1] = ['1', 'Agnès', 'a.1@asl.com', 'woman', 'lectra', 'user'];
        self::$user[2] = ['2', 'Alan', 'a.2@asl.com', 'man', 'subcontractor', 'user'];
        self::$user[3] = ['3', 'Annabel', 'a.3@asl.com', 'woman', 'lectra', 'user'];
        self::$user[4] = ['4', 'Antoine', 'a.4@asl.com', 'man', 'lectra', 'user'];
        self::$user[5] = ['5-Leclaire', 'Ariane', 'a.pennarun-5@asl.com', 'woman', 'lectra', 'user'];
        self::$user[6] = ['6', 'Arnaud', 'a.6@asl.com', 'man', 'lectra', 'user'];
        self::$user[7] = ['7', 'Bastien', 'b.7@asl.com', 'man', 'lectra', 'user'];
        self::$user[8] = ['8', 'Benoit', 'b.8@asl.com', 'man', 'lectra', 'user'];
        self::$user[9] = ['9', 'Bruno', 'b.9@asl.com', 'man', 'lectra', 'user'];
        self::$user[10] = ['10', 'Cédric', 'c.10@asl.com', 'man', 'subcontractor', 'user'];
        self::$user[11] = ['11', 'Cédric', 'c.11@asl.com', 'man', 'lectra', 'user'];
        self::$user[12] = ['12-Hanusse', 'Céline', 'c.becker-12@asl.com', 'woman', 'lectra', 'user'];
        self::$user[13] = ['13', 'Céline', '13@asl.fr', 'woman', 'conjoint', 'user'];
        self::$user[14] = ['14', 'Christian', 'c.14@asl.com', 'man', 'lectra', 'user'];
        self::$user[15] = ['15', 'Christophe', 'c.15@asl.com', 'man', 'lectra', 'user'];
        self::$user[16] = ['16', 'Christophe', 'c.16@asl.com', 'man', 'lectra', 'admin'];
        self::$user[17] = ['17', 'Clement', 'c.17@asl.com', 'man', 'lectra', 'user'];
        self::$user[18] = ['18', 'Corinne', 'c.18@asl.com', 'woman', 'lectra', 'user'];
        self::$user[19] = ['19', 'David', 'd.19@asl.com', 'man', 'lectra', 'user'];
        self::$user[20] = ['20', 'Denis', 'd.20@asl.com', 'man', 'lectra', 'user'];
        self::$user[21] = ['21', 'Dominique', 'd.21@asl.com', 'woman', 'lectra', 'user'];
        self::$user[22] = ['22', 'Emmanuelle', '22@asl.fr', 'woman', 'conjoint', 'user'];
        self::$user[23] = ['23', 'Eric', 'e.23@asl.com', 'man', 'lectra', 'user'];
        self::$user[24] = ['24', 'Eric', 'e.24@asl.com', 'man', 'lectra', 'user'];
        self::$user[25] = ['25', 'Fabrice', 'f.25@asl.com', 'man', 'lectra', 'user'];
        self::$user[26] = ['26', 'Florian', 'f.26@asl.com', 'man', 'lectra', 'user'];
        self::$user[27] = ['27', 'Francoise', 'f.27@asl.com', 'woman', 'lectra', 'user'];
        self::$user[28] = ['28', 'Géraldine', 'g.28@asl.com', 'woman', 'lectra', 'user'];
        self::$user[29] = ['29', 'Géraldine', 'g.29@asl.com', 'woman', 'lectra', 'user'];
        self::$user[30] = ['30', 'Hervé', 'h.30@asl.com', 'man', 'lectra', 'user'];
        self::$user[31] = ['31', 'Isabelle', 'i.31@asl.com', 'woman', 'lectra', 'user'];
        self::$user[32] = ['32', 'Jamaique', 'j.32@asl.com', 'man', 'lectra', 'user'];
        self::$user[33] = ['33', 'Jean-Luc', 'jl.33@asl.com', 'man', 'lectra', 'user'];
        self::$user[34] = ['34', 'Jean-Michel', 'jm.34@asl.com', 'man', 'lectra', 'user'];
        self::$user[35] = ['35', 'Jérôme', 'j.35@asl.com', 'man', 'lectra', 'user'];
        self::$user[36] = ['36', 'Jérôme', 'j.36@asl.com', 'man', 'lectra', 'user'];
        self::$user[37] = ['37', 'Josiane', 'j.37@asl.com', 'woman', 'lectra', 'user'];
        self::$user[38] = ['38', 'Julien', 'j.38@asl.com', 'man', 'lectra', 'user'];
        self::$user[39] = ['39', 'Kerstin', 'k.39@asl.com', 'woman', 'lectra', 'user'];
        self::$user[40] = ['40-Beyronneau', 'Laetitia', 'l.bonci-40@asl.com', 'woman', 'lectra', 'user'];
        self::$user[41] = ['41', 'Laureen', 'l.41@asl.com', 'woman', 'lectra', 'user'];
        self::$user[42] = ['42', 'Laurent', 'l.42@asl.com', 'man', 'lectra', 'user'];
        self::$user[43] = ['43', 'Loïc', 'l.43@asl.com', 'man', 'lectra', 'user'];
        self::$user[44] = ['44', 'Loïc', 'l.44@asl.com', 'man', 'lectra', 'user'];
        self::$user[45] = ['45', 'Mari-Claire ', 'mc.45@asl.com', 'woman', 'lectra', 'user'];
        self::$user[46] = ['46', 'Mathieu', 'm.46@asl.com', 'man', 'lectra', 'user'];
        self::$user[47] = ['47', 'Matthieu', 'm.47@asl.com', 'man', 'lectra', 'user'];
        self::$user[48] = ['48', 'Maxime', '48@asl.com', 'man', 'child', 'admin'];
        self::$user[49] = ['49', 'Michel', 'm.49@asl.com', 'man', 'lectra', 'user'];
        self::$user[50] = ['50', 'Mireille', 'm.50@asl.com', 'woman', 'lectra', 'user'];
        self::$user[51] = ['51', 'Nicolas', 'n.51@asl.com', 'man', 'lectra', 'user'];
        self::$user[52] = ['52', 'Nicolas', 'n.52@asl.com', 'man', 'lectra', 'user'];
        self::$user[53] = ['53', 'Pascal', 'p.53@asl.com', 'man', 'lectra', 'user'];
        self::$user[54] = ['54', 'Patrick', 'p.54@asl.com', 'man', 'lectra', 'user'];
        self::$user[55] = ['55', 'Philippe', 'p.55@asl.com', 'man', 'lectra', 'user'];
        self::$user[56] = ['56', 'Philippe', 'p.56@asl.com', 'man', 'lectra', 'user'];
        self::$user[57] = ['57', 'Régis', 'r.57@asl.com', 'man', 'lectra', 'user'];
        self::$user[58] = ['58', 'Rémi', '58@asl.com', 'man', 'conjoint', 'user'];
        self::$user[59] = ['59', 'Sébastien', 's.59@asl.com', 'man', 'lectra', 'user'];
        self::$user[60] = ['60', 'Sébastien', 's.60@asl.com', 'man', 'lectra', 'user'];
        self::$user[61] = ['61', 'Stéphane', 's.61@asl.com', 'man', 'lectra', 'user'];
        self::$user[62] = ['62', 'Stéphane', 's.62@asl.com', 'man', 'lectra', 'user'];
        self::$user[63] = ['63', 'Stéphanie', 's.63@asl.com', 'woman', 'lectra', 'user'];
        self::$user[64] = ['64', 'Sylvain', 's.64@asl.com', 'man', 'lectra', 'user'];
        self::$user[65] = ['65', 'Sylvain', 's.65@asl.com', 'man', 'lectra', 'user'];
        self::$user[66] = ['66', 'Thierry', 't.66@asl.com', 'man', 'lectra', 'user'];
        self::$user[67] = ['67', 'Vanessa', '67@asl.fr', 'woman', 'external', 'user'];
        self::$user[68] = ['68', 'Vincent', 'beuzeville.68@asl.com', 'man', 'conjoint', 'user'];
        self::$user[69] = ['69', 'Yannick', 'y.69@asl.com', 'man', 'lectra', 'user'];
        self::$user[70] = ['70', 'Yannick', 'y.70@asl.com', 'man', 'lectra', 'user'];
        self::$user[71] = ['71', 'Yoann', 'y.71@asl.com', 'man', 'lectra', 'user'];
        self::$user[72] = ['72', 'Yoann', 'y.72@asl.com', 'man', 'trainee', 'user'];
    }

    public function run()
    {
        foreach (self::$user as $user)
        {
            User::create([
                'name'                => $user[0],
                'forname'             => $user[1],
                'email'               => $user[2],
                'birthday'            => Carbon::create(1996, 9, 20)->format('d/m/Y'),
                'tshirt_size'         => 'M',
                'gender'              => $user[3],
                'address'             => 'UneAdresse',
                'phone'               => '0604034523',
                'license'             => null,
                'active'              => true,
                'state'               => 'active',
                'ending_holiday'      => Carbon::now()->format('d/m/Y'),
                'ending_injury'       => Carbon::now()->format('d/m/Y'),
                'lectra_relationship' => $user[4],
                'newsletter'          => true,
                'avatar'              => false,
                'role'                => $user[5],
                'first_connect'       => false,
                'password'            => bcrypt('mmmmmm'),
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
            ]);
        }
    }

}