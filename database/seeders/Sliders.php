<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Sliders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('webserver')->table('config_slider')->insert([
          'id'         => 1,
          'title'      => 'Hello',
          'path'       => 'images/slider.jpg'
        ]);
    }
}
