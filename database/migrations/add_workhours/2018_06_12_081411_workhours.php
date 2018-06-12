<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Workhours extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workhours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('type'); // hazamenetel vagy bejött
            $table->timestamps();
        });

        Schema::create('user_work_hours', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('work_hours_id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workhours');
        Schema::dropIfExists('user_work_hours');
    }
}
