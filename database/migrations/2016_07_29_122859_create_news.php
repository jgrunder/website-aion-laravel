<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNews extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('webserver')->create('news', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('text');
            $table->integer('account_id');
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
		Schema::connection('webserver')->drop('news');
	}

}
