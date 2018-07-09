<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        $miwrk3hzm7_permissions = array(
            array('id' => '1','name' => 'Bármilyen szabadságot','description' => 'Bárki nevében felvihet szabadságot','created_at' => NULL,'updated_at' => '2018-01-17 14:28:13'),
            array('id' => '2','name' => 'Minden szabadság','description' => 'Mindenkinek látja a szabadságát','created_at' => NULL,'updated_at' => NULL),
            array('id' => '3','name' => 'profil megtekintés','description' => 'Más profilját megtekintheti','created_at' => NULL,'updated_at' => NULL),
            array('id' => '4','name' => 'Profil szerkesztés','description' => 'Más profilját szerkesztheti','created_at' => NULL,'updated_at' => NULL),
            array('id' => '5','name' => 'Jog admin
','description' => 'Jogok szerkesztése','created_at' => NULL,'updated_at' => NULL),
            array('id' => '6','name' => 'céges szabadságok','description' => 'Csak a saját cégeinek a szabadságait látja','created_at' => NULL,'updated_at' => '2018-01-18 08:59:15'),
            array('id' => '7','name' => 'saját profil ','description' => 'Saját profil szerkesztése','created_at' => NULL,'updated_at' => NULL),
            array('id' => '8','name' => 'Új felhasználó felvitel','description' => 'Új felhasználó létrehozása','created_at' => NULL,'updated_at' => NULL),
            array('id' => '9','name' => 'Profil lista','description' => 'Felhasználók listázása','created_at' => NULL,'updated_at' => NULL),
            array('id' => '10','name' => 'Cégek listázása','description' => 'Engedélyezi kilistázni a cégeket','created_at' => NULL,'updated_at' => NULL),
            array('id' => '11','name' => 'Felhasználó törlés','description' => 'Engedély a felhasználó törlésére','created_at' => NULL,'updated_at' => NULL),
            array('id' => '12','name' => 'Cég szerkesztés','description' => 'Cég profiljának megtekintése','created_at' => NULL,'updated_at' => NULL),
            array('id' => '13','name' => 'szabi törlés','description' => '.....','created_at' => NULL,'updated_at' => NULL),
            array('id' => '14','name' => 'szabi törlés másnál','description' => '.....','created_at' => NULL,'updated_at' => NULL),
            array('id' => '15','name' => 'szabi módosítás másnál','description' => '.....','created_at' => NULL,'updated_at' => NULL),
            array('id' => '16','name' => 'szabi módosítás','description' => 'saját szabi módosítás','created_at' => NULL,'updated_at' => NULL),
            array('id' => '17','name' => 'szabi megtekintés másnál','description' => '....
','created_at' => NULL,'updated_at' => NULL),
            array('id' => '18','name' => 'jelenléti','description' => 'jelenléti szerkesztés, most még minden','created_at' => NULL,'updated_at' => NULL)
        );

        foreach ($miwrk3hzm7_permissions as $permission) {
            \App\Permission::create($permission);
        }
    }


}
