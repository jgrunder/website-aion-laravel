<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsAllopass extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('webserver')->create('logs_allopass', function ($table) {
            $table->string('id_allopass');
            $table->integer('id_account');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('webserver')->drop('logs_allopass');
	}

}
