<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsPaypal extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('webserver')->create('logs_paypal', function ($table) {
            $table->increments('id');
            $table->integer('id_account');
            $table->string('status');
            $table->string('price');
            $table->string('txnid');
            $table->string('amount');
            $table->string('name');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('email');
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
		Schema::connection('webserver')->drop('logs_paypal');
	}

}
