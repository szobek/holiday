<?php

use App\HolidayTypes;
use Illuminate\Database\Seeder;

class HolidayTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        HolidayTypes::create([
            "name" => "Normál"
        ]);

        HolidayTypes::create([
            "name" => "Betegség"
        ]);

        HolidayTypes::create([
            "name" => "Egyéb"
        ]);

    }
}
