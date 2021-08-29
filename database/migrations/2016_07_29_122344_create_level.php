<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('loginserver')->table('account_data', function ($table) {
            $table->integer('level')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::connection('loginserver')->table('account_data', function ($table) {
            $table->dropColumn('level');
        });
	}

}
