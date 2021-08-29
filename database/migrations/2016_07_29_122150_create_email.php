<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmail extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('loginserver')->table('account_data', function ($table) {
            $table->string('email')->nullable()->default(null)->after('name');
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
            $table->dropColumn('email');
        });
	}

}
