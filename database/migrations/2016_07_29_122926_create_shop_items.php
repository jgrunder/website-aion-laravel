<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('webserver')->create('shop_items', function ($table) {
            $table->increments('id');
            $table->integer('id_sub_category');
            $table->string('id_item');
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('level')->default(0);
            $table->integer('purchased');
            $table->string('quality_item');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('webserver')->drop('shop_items');
	}

}
