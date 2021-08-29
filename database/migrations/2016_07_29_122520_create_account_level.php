<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLevel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('loginserver')->create('account_level', function ($table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('level');
            $table->integer('total');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('loginserver')->drop('account_level');
	}

}
