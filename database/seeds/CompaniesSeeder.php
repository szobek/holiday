<?php

use App\Companies;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $companies = [
            [
                "name" => "MŰSZERFAL Informatikai Tanácsadó Korlátolt Felelősségű Társaság",
                "address" => "4025 Debrecen, Hatvan utca 56. tetőtér 13.",
                "short_name" => "Műszerfal kft.",
                "tax" => "24217482-2-09",
            ],
            [
                "name" => "Versenyhajó Értékteremtési és Tanácsadó Korlátolt Felelősségű Társaság",
                "address" => "1015 Budapest, Batthyány utca 2. II/12",
                "short_name" => "Versenyhajó kft.",
                "tax" => "14517884-2-14",
            ],

        ];

        foreach ($companies as $company) {
            Companies::create($company);
        }




    }
}
