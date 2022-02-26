<?php

namespace Database\Factories;

use App\Models\Commerce;
use App\Models\CommerceBranches;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommerceBranchesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommerceBranches::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fakePhrase = $this->faker->catchPhrase;

        return [
            'commerce_id' => Commerce::factory(),
            'name' => Str::slug($fakePhrase),
            'fullname' => $fakePhrase,
            'address' => $this->faker->word . ', ' . $this->faker->word . ' ' . $this->faker->randomDigit,
        ];
    }
}
