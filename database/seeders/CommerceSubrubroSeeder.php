<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommerceSubrubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commerce_subrubro')->insert([
            ['commerce_id' => 1, 'subrubro_id' => 1],
            ['commerce_id' => 1, 'subrubro_id' => 2],
            ['commerce_id' => 1, 'subrubro_id' => 3],
            ['commerce_id' => 2, 'subrubro_id' => 1],
            ['commerce_id' => 2, 'subrubro_id' => 2],
        ]);
    }
}
