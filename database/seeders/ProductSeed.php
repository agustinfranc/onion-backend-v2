<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'code' => 1,
                'commerce_id' => 1,
                'subrubro_id' => 1,
                'name' => 'Espresso',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 2,
                'commerce_id' => 1,
                'subrubro_id' => 1,
                'name' => 'Machiatto',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 3,
                'commerce_id' => 1,
                'subrubro_id' => 2,
                'name' => 'Lemon Pie',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 9,
                'commerce_id' => 1,
                'subrubro_id' => 2,
                'name' => 'Strawberry Pie',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 10,
                'commerce_id' => 1,
                'subrubro_id' => 2,
                'name' => 'Melon Pie',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 4,
                'commerce_id' => 1,
                'subrubro_id' => 3,
                'name' => 'Medialuna',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 5,
                'commerce_id' => 1,
                'subrubro_id' => 5,
                'name' => 'Lomo',
                'description' => Str::random(100),
                'price' => random_int(100, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 6,
                'commerce_id' => 1,
                'subrubro_id' => 5,
                'name' => 'Pollo',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 7,
                'commerce_id' => 1,
                'subrubro_id' => 9,
                'name' => 'Levite',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
            [
                'code' => 8,
                'commerce_id' => 1,
                'subrubro_id' => 7,
                'name' => 'Coca',
                'description' => Str::random(100),
                'price' => random_int(10, 999),
                'avatar_dirname' => 'https://api.onion.ar/storage/images/xd6nUAyy74DXgMIeR4JvzZ8yZGtHHcE8alU3jidv.jpg',
            ],
        ]);
    }
}
