<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommerceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commerce_user')->insert([
            ['commerce_id' => 1, 'user_id' => 1],
            ['commerce_id' => 1, 'user_id' => 2],
            ['commerce_id' => 2, 'user_id' => 1],
        ]);
    }
}
