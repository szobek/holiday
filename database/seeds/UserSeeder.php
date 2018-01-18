<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
            "company" => 1,
        ]);
        User::create([
            "name" => "Zeliska Nikolett",
            "email" => "nikolett@gmail.com",
            "password" => Hash::make('123456789'),
            "company" => 2,
        ]);
        User::create([
            "name" => "Ulviczki Attila",
            "email" => "ulviczki@gmail.com",
            "password" => Hash::make('123456789'),
            "company" => 1,
        ]);
        User::create([
            "name" => "Bárdos Mihály",
            "email" => "miso470@gmail.com",
            "password" => Hash::make('123456789'),
            "company" => 2,
        ]);
        User::create([
            "name" => "Szalai Zsolt",
            "email" => "szzsolt@gmail.com",
            "password" => Hash::make('123456789'),
            "company" => 2,
        ]);
        User::create([
            "name" => "Szendrői Dávid",
            "email" => "szendroi@gmail.com",
            "password" => Hash::make('123456789'),
            "company" => 2,
        ]);
        User::create([
            "name" => "Gubacska Anikó",
            "email" => "gubacska@gmail.com",
            "password" => Hash::make('123456789'),
            "company" => 2,
        ]);


    }
}
