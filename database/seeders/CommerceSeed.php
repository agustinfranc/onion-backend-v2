<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommerceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commerces')->insert([
            ['id' => 1, 'name' => 'marlon', 'fullname' => 'Marlon Resto Bar', 'assets_dirname' => 'https://onion.com.ar/img/marlon/'],
            ['id' => 2, 'name' => 'plaza', 'fullname' => 'Plaza Del Carmen', 'assets_dirname' => 'https://onion.com.ar/img/plaza/'],
        ]);
    }
}
