<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubrubroSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subrubros')->insert([
            [
                'id' => 1,
                'rubro_id' => 1,
                'name' => 'Cafeteria General',
                'is_general' => true,
            ],
            [
                'id' => 2,
                'rubro_id' => 1,
                'name' => 'Tortas',
                'is_general' => false,
            ],
            [
                'id' => 3,
                'rubro_id' => 1,
                'name' => 'Facturas',
                'is_general' => false,
            ],
            [
                'id' => 4,
                'rubro_id' => 2,
                'name' => 'Cocina General',
                'is_general' => true,
            ],
            [
                'id' => 5,
                'rubro_id' => 2,
                'name' => 'Carnes',
                'is_general' => false,
            ],
            [
                'id' => 6,
                'rubro_id' => 2,
                'name' => 'Tartas',
                'is_general' => false,
            ],
            [
                'id' => 7,
                'rubro_id' => 3,
                'name' => 'Bebidas General',
                'is_general' => true,
            ],
            [
                'id' => 8,
                'rubro_id' => 3,
                'name' => 'Con Alcohol',
                'is_general' => false,
            ],
            [
                'id' => 9,
                'rubro_id' => 3,
                'name' => 'Saborizadas',
                'is_general' => false,
            ],
        ]);
    }
}
