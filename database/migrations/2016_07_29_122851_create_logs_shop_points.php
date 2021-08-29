<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsShopPoints extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('webserver')->create('logs_shop_points', function ($table) {
            $table->increments('id');
            $table->string('sender_name');
            $table->string('receiver_name');
            $table->string('reason');
            $table->string('points');
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
		Schema::connection('webserver')->drop('logs_shop_points');
	}

}
