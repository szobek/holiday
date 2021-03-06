<?php

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
         $this->call(UserSeeder::class);
        $this->call(HolidayTypesSeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
