<?php

namespace Database\Factories;

use App\Models\ProductOptionsGroupe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionsGroupeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOptionsGroupe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => random_int(1, 9),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'multiple' => (bool) random_int(0, 1),
            'required' => (bool) random_int(0, 1),
        ];
    }
}
