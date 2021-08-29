<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopHistory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('webserver')->create('shop_history', function ($table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('player_id');
            $table->string('player_name');
            $table->string('item_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('name');
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
		Schema::connection('webserver')->drop('shop_history');
	}

}
