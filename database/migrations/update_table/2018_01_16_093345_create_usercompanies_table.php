<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsercompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('companies_id');
            $table->timestamps();
        });
    }

    /*
     * php artisan migrate --path=/database/migrations/2018_01_16_093345_create_usercompanies_table.php
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_user');
    }
}
