<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            ['id' => 1, 'name' => 'Peso Argentino', 'code' => 'ARS', 'symbol' => '$'],
            ['id' => 2, 'name' => 'Dolar Estadounidense', 'code' => 'USD', 'symbol' => '$'],
            ['id' => 3, 'name' => 'Kuwaiti Dinars', 'code' => 'KMD', 'symbol' => 'KD'],
            ['id' => 4, 'name' => 'Dirhams UAE', 'code' => 'AED', 'symbol' => 'AED'],
            ['id' => 5, 'name' => 'Colon Costarricense', 'code' => 'CRC', 'symbol' => '₡'],
        ]);
    }
}
