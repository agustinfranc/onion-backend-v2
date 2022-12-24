<?php

namespace Database\Factories;

use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_options_groupe_id' => random_int(1, 3),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 20, 1000),
        ];
    }
}
