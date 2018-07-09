<?php

use App\User;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Kunszt Norbert",
            "email" => "kunszt.norbert@gmail.com",
            "password" => Hash::make('123456789'),
            "holidays" => 23,
        ]);

        User::create([
            "name" => "Kiss Pista",
            "email" => "muszerfal.fejlesztok@gmail.com",
            "password" => Hash::make('123456789'),
            "holidays" => 18,
        ]);

        $permissions = \App\Permission::all();

        foreach ($permissions as $permission) {
           \App\PermissionUser::create([
               "user_id"=>1,
               "permission_id"=>$permission->id
           ]);
        }
    }
}
