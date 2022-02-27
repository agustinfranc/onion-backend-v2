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
            ['id' => 1, 'name' => 'marlon', 'fullname' => 'Marlon Resto Bar', 'cover_dirname' => 'https://api.onion.ar/storage/images/QKyxo1mKnsoZzC1u0MWDjjnujrLXIQ2srPgNvaK3.jpg', 'avatar_dirname' => 'https://api.onion.ar/storage/images/hz5FQnqJk04hRp4isLSl7XpyjmKpcBqEl1kOiiZI.jpg' , 'can_order' => true],
            ['id' => 2, 'name' => 'plaza', 'fullname' => 'Plaza Del Carmen', 'cover_dirname' => 'https://onion.com.ar/img/plaza/', 'avatar_dirname' => 'https://api.onion.ar/storage/images/hz5FQnqJk04hRp4isLSl7XpyjmKpcBqEl1kOiiZI.jpg', 'can_order' => false],
        ]);
    }
}
