<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('gameserver')->create('myshop', function ($table) {
            $table->increments('id');
            $table->integer('player_id');
            $table->string('item');
            $table->integer('nb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('gameserver')->drop('myshop');
    }
}
