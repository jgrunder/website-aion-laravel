<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushbullet extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('loginserver')->table('account_data', function ($table) {
            $table->string('pushbullet')->nullable()->default(null)->after('email');
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
            $table->dropColumn('pushbullet');
        });
	}

}
