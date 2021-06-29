<?php

namespace Database\Factories;

use App\Models\Commerce;
use App\Models\Product;
use App\Models\Subrubro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'subrubro_id' => Subrubro::factory(),
            'commerce_id' => Commerce::factory(),
            'code' => $this->faker->randomDigit,
            'price' => $this->faker->randomFloat(2, 20, 1000),
            'description' => $this->faker->sentence,
            'disabled' => false,
            'avatar' => '',
            'avatar_dirname' => $this->faker->imageUrl(360, 360),
        ];
    }
}
