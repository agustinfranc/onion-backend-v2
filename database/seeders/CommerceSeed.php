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
            ['id' => 1, 'name' => 'plaza', 'assets_dirname' => 'https://admin-onion.com.ar/img/marlon/'],
            ['id' => 2, 'name' => 'marlon', 'assets_dirname' => 'https://admin-onion.com.ar/img/marlon/'],
        ]);
    }
}
