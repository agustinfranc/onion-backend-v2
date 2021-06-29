<?php

namespace Database\Factories;

use App\Models\Rubro;
use App\Models\Subrubro;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubrubroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subrubro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rubro_id' => Rubro::factory(),
            'name' => $this->faker->word,
        ];
    }
}
