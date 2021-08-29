<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountVotes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('loginserver')->create('account_votes', function ($table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('site');
            $table->integer('add');
            $table->dateTime('date');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('loginserver')->drop('account_votes');
	}

}
