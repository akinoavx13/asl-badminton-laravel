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
        self::$user[1] = ['Bodereau', 'Agnès', 'a.bodereau@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[2] = ['Lemaire', 'Alan', 'a.lemaire@lectra.com', 'man', 'subcontractor', 'user'];
        self::$user[3] = ['Raymond', 'Annabel', 'a.raymond@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[4] = ['Mercier', 'Antoine', 'a.mercier@lectra.com', 'man', 'lectra', 'user'];
        self::$user[5] = ['Pennarun-Leclaire', 'Ariane', 'a.pennarun-leclair@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[6] = ['Crepin', 'Arnaud', 'a.crepin@lectra.com', 'man', 'lectra', 'user'];
        self::$user[7] = ['Laborde', 'Bastien', 'b.laborde@lectra.com', 'man', 'lectra', 'user'];
        self::$user[8] = ['Linieres', 'Benoit', 'b.linieres@lectra.com', 'man', 'lectra', 'user'];
        self::$user[9] = ['Valeze', 'Bruno', 'b.valeze@lectra.com', 'man', 'lectra', 'user'];
        self::$user[10] = ['Paillat', 'Cédric', 'c.paillat@lectra.com', 'man', 'subcontractor', 'user'];
        self::$user[11] = ['Syllebranque', 'Cédric', 'c.syllebranque@lectra.com', 'man', 'lectra', 'user'];
        self::$user[12] = ['Becker-Hanusse', 'Céline', 'c.becker-hanusse@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[13] = ['Chagnaud', 'Céline', 'cpouxviel@voila.fr', 'woman', 'conjoint', 'user'];
        self::$user[14] = ['Nicolas', 'Christian', 'c.nicolas@lectra.com', 'man', 'lectra', 'user'];
        self::$user[15] = ['Grellier', 'Christophe', 'c.grellier@lectra.com', 'man', 'lectra', 'user'];
        self::$user[16] = ['Mahéo', 'Christophe', 'c.maheo@lectra.com', 'man', 'lectra', 'admin'];
        self::$user[17] = ['Peille', 'Clement', 'c.peille@lectra.com', 'man', 'lectra', 'user'];
        self::$user[18] = ['Fabbro', 'Corinne', 'c.fabbro@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[19] = ['Garofoli', 'David', 'd.garofoli@lectra.com', 'man', 'lectra', 'user'];
        self::$user[20] = ['Maurin', 'Denis', 'd.maurin@lectra.com', 'man', 'lectra', 'user'];
        self::$user[21] = ['Gerbeaud', 'Dominique', 'd.gerbeaud@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[22] = ['Moret', 'Emmanuelle', 'moretmanue@yahoo.fr', 'woman', 'conjoint', 'user'];
        self::$user[23] = ['Portafax', 'Eric', 'e.portafax@lectra.com', 'man', 'lectra', 'user'];
        self::$user[24] = ['Beaulieu', 'Eric', 'e.beaulieu@lectra.com', 'man', 'lectra', 'user'];
        self::$user[25] = ['Guitteny', 'Fabrice', 'f.guitteny@lectra.com', 'man', 'lectra', 'user'];
        self::$user[26] = ['Larrue', 'Florian', 'f.larrue@lectra.com', 'man', 'lectra', 'user'];
        self::$user[27] = ['Marciquet', 'Francoise', 'f.marciquet@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[28] = ['Monnier', 'Géraldine', 'g.monnier@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[29] = ['Moreau', 'Géraldine', 'g.moreau@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[30] = ['Gateuil', 'Hervé', 'h.gateuil@lectra.com', 'man', 'lectra', 'user'];
        self::$user[31] = ['Degand', 'Isabelle', 'i.degand@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[32] = ['Arlix', 'Jamaique', 'j.arlix@lectra.com', 'man', 'lectra', 'user'];
        self::$user[33] = ['Geraut', 'Jean-Luc', 'jl.geraut@lectra.com', 'man', 'lectra', 'user'];
        self::$user[34] = ['Roiné', 'Jean-Michel', 'jm.roine@lectra.com', 'man', 'lectra', 'user'];
        self::$user[35] = ['Arrault', 'Jérôme', 'j.arrault@lectra.com', 'man', 'lectra', 'user'];
        self::$user[36] = ['Grienenberger', 'Jérôme', 'j.grienenberger@lectra.com', 'man', 'lectra', 'user'];
        self::$user[37] = ['Lasguignes', 'Josiane', 'j.lasguignes@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[38] = ['Fouilloux', 'Julien', 'j.fouilloux@lectra.com', 'man', 'lectra', 'user'];
        self::$user[39] = ['Carrere', 'Kerstin', 'k.carrere@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[40] = ['Bonci-Beyronneau', 'Laetitia', 'l.bonci-beyronneau@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[41] = ['Sinegre', 'Laureen', 'l.sinegre@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[42] = ['Lepic', 'Laurent', 'l.lepic@lectra.com', 'man', 'lectra', 'user'];
        self::$user[43] = ['Eymat', 'Loïc', 'l.eymat@lectra.com', 'man', 'lectra', 'user'];
        self::$user[44] = ['Jézéquel', 'Loïc', 'l.jezequel@lectra.com', 'man', 'lectra', 'user'];
        self::$user[45] = ['Bavoix', 'Mari-Claire ', 'mc.bavoix@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[46] = ['Bonenfant', 'Mathieu', 'm.bonenfant@lectra.com', 'man', 'lectra', 'user'];
        self::$user[47] = ['Shioda', 'Matthieu', 'm.shioda@lectra.com', 'man', 'lectra', 'user'];
        self::$user[48] = ['Mahéo', 'Maxime', 'imaxame@gmail.com', 'man', 'child', 'admin'];
        self::$user[49] = ['Boetsch', 'Michel', 'm.boetsch@lectra.com', 'man', 'lectra', 'user'];
        self::$user[50] = ['Roche', 'Mireille', 'm.roche@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[51] = ['Jouanlanne', 'Nicolas', 'n.jouanlanne@lectra.com', 'man', 'lectra', 'user'];
        self::$user[52] = ['Sonnier', 'Nicolas', 'n.sonnier@lectra.com', 'man', 'lectra', 'user'];
        self::$user[53] = ['Chabot', 'Pascal', 'p.chabot@lectra.com', 'man', 'lectra', 'user'];
        self::$user[54] = ['Canovas', 'Patrick', 'p.canovas@lectra.com', 'man', 'lectra', 'user'];
        self::$user[55] = ['Lacoux', 'Philippe', 'p.lacoux@lectra.com', 'man', 'lectra', 'user'];
        self::$user[56] = ['Moret', 'Philippe', 'p.moret@lectra.com', 'man', 'lectra', 'user'];
        self::$user[57] = ['Lainé', 'Régis', 'r.laine@lectra.com', 'man', 'lectra', 'user'];
        self::$user[58] = ['Fabre', 'Rémi', 'remifabre1800@gmail.com', 'man', 'conjoint', 'user'];
        self::$user[59] = ['Duchesne', 'Sébastien', 's.duchesne@lectra.com', 'man', 'lectra', 'user'];
        self::$user[60] = ['Lansiaux', 'Sébastien', 's.lansiaux@lectra.com', 'man', 'lectra', 'user'];
        self::$user[61] = ['Barbe', 'Stéphane', 's.barbe@lectra.com', 'man', 'lectra', 'user'];
        self::$user[62] = ['Bodivit', 'Stéphane', 's.bodivit@lectra.com', 'man', 'lectra', 'user'];
        self::$user[63] = ['Bee', 'Stéphanie', 's.bee@lectra.com', 'woman', 'lectra', 'user'];
        self::$user[64] = ['Guilbert', 'Sylvain', 's.guilbert@lectra.com', 'man', 'lectra', 'user'];
        self::$user[65] = ['Leroux', 'Sylvain', 's.leroux@lectra.com', 'man', 'lectra', 'user'];
        self::$user[66] = ['Badie', 'Thierry', 't.badie@lectra.com', 'man', 'lectra', 'user'];
        self::$user[67] = ['Balci', 'Vanessa', 'vanessabalci@yahoo.fr', 'woman', 'external', 'user'];
        self::$user[68] = ['Beuzeville', 'Vincent', 'beuzeville.vincent@gmail.com', 'man', 'conjoint', 'user'];
        self::$user[69] = ['Guillemot', 'Yannick', 'y.guillemot@lectra.com', 'man', 'lectra', 'user'];
        self::$user[70] = ['Jocardes', 'Yannick', 'y.jocardes@lectra.com', 'man', 'lectra', 'user'];
        self::$user[71] = ['Bourget', 'Yoann', 'y.bourget@lectra.com', 'man', 'lectra', 'user'];
        self::$user[72] = ['Augias', 'Yoann', 'y.augias@lectra.com', 'man', 'trainee', 'user'];
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
                'address'             => '3 rue du Maréchal Lyautey',
                'phone'               => '0604073165',
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