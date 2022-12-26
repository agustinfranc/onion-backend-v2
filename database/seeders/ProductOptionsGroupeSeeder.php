<?php

namespace Database\Seeders;

use App\Models\ProductOptionsGroupe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductOptionsGroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductOptionsGroupe::factory(3)->create();
    }
}
