<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviewInShopItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('webserver')->table('shop_items', function($table) {
          $table->integer('preview')->default(1);
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
         $table->dropColumn(['preview']);
      });
    }
}
