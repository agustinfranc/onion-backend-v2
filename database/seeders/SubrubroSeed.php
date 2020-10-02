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
            ],
            [
                'id' => 2,
                'rubro_id' => 1,
                'name' => 'Tortas',
            ],
            [
                'id' => 3,
                'rubro_id' => 1,
                'name' => 'Facturas',
            ],
            [
                'id' => 4,
                'rubro_id' => 2,
                'name' => 'Cocina General',
            ],
            [
                'id' => 5,
                'rubro_id' => 2,
                'name' => 'Carnes',
            ],
            [
                'id' => 6,
                'rubro_id' => 2,
                'name' => 'Tartas',
            ],
            [
                'id' => 7,
                'rubro_id' => 3,
                'name' => 'Bebidas General',
            ],
            [
                'id' => 8,
                'rubro_id' => 3,
                'name' => 'Con Alcohol',
            ],
            [
                'id' => 9,
                'rubro_id' => 3,
                'name' => 'Saborizadas',
            ],
        ]);
    }
}
