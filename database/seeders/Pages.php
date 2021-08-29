<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pages extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('webserver')->table('pages')->insert([
          'id'        => 1,
          'page_name' => 'rules',
          'fr'        => '',
          'en'        => ''
        ]);

        DB::connection('webserver')->table('pages')->insert([
          'id'        => 2,
          'page_name' => 'team',
          'fr'        => '',
          'en'        => ''
        ]);

        DB::connection('webserver')->table('pages')->insert([
          'id'        => 3,
          'page_name' => 'teamspeak',
          'fr'        => '',
          'en'        => ''
        ]);

        DB::connection('webserver')->table('pages')->insert([
          'id'        => 4,
          'page_name' => 'subscribe',
          'fr'        => '',
          'en'        => ''
        ]);

        DB::connection('webserver')->table('pages')->insert([
          'id'        => 5,
          'page_name' => 'joinus',
          'fr'        => '',
          'en'        => ''
        ]);

        DB::connection('webserver')->table('pages')->insert([
          'id'        => 6,
          'page_name' => 'rates',
          'fr'        => '',
          'en'        => ''
        ]);
    }
}
