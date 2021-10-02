<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShopItemRace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('webserver')->table('shop_items', function($table) {
            $table->varchar('race')->default('ALL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('webserver')->table('shop_items', function($table) {
           $table->dropColumn(['race']);
        });
    }
}
