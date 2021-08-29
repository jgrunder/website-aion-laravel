<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPoints extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::connection('loginserver')->table('account_data', function ($table) {
            $table->integer('shop_points')->default(0)->after('toll');
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
            $table->dropColumn('shop_points');
        });
	}

}
