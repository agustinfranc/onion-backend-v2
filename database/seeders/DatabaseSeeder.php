<?php

namespace Database\Seeders;

use App\Models\CommerceBranch;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        $this->call(CommerceSeed::class);

        CommerceBranch::factory(2)->create([
            'commerce_id' => 1,
        ]);

        $this->call(CommerceUserSeeder::class);
        $this->call(RubroSeed::class);
        $this->call(CommerceRubroSeeder::class);
        $this->call(SubrubroSeed::class);
        $this->call(CommerceSubrubroSeeder::class);
        $this->call(ProductSeed::class);
        $this->call(CurrencySeeder::class);
        $this->call(ProductOptionsGroupeSeeder::class);
        $this->call(ProductOptionSeeder::class);
    }
}
