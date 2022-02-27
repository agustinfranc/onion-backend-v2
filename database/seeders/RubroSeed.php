<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RubroSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rubros')->insert([
            [
                'id' => 1,
                'name' => 'Cafeteria',
                'link_name' => 'cafeteria',
            ],
            [
                'id' => 2,
                'name' => 'Cocina',
                'link_name' => 'cocina',
            ],
            [
                'id' => 3,
                'name' => 'Bebidas',
                'link_name' => 'bebidas',
            ],
        ]);
    }
}
