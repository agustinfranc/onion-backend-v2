<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommerceRubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commerce_rubro')->insert([
            ['commerce_id' => 1, 'rubro_id' => 1],
            ['commerce_id' => 1, 'rubro_id' => 2],
            ['commerce_id' => 1, 'rubro_id' => 3],
            ['commerce_id' => 2, 'rubro_id' => 1],
            ['commerce_id' => 2, 'rubro_id' => 2],
        ]);
    }
}
