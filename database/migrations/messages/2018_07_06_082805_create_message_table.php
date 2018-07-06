<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->timestamps();
        });


        Schema::create('conversations_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->integer('receiver_read');
            $table->text('content');
            $table->timestamps();
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('conversations_messages');
    }
}
