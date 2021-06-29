<?php

namespace Database\Factories;

use App\Models\Commerce;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommerceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commerce::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::slug($this->faker->catchPhrase),
            'fullname' => $this->faker->catchPhrase,
            'cover_dirname' => 'https://picsum.photos/510/300?random',
            'avatar_dirname' => 'https://picsum.photos/510/300?random',
            'currency_id' => Currency::factory(),
            'dark_theme' => 1,
            'has_action_buttons' => 0,
            'has_footer' => 1,
        ];
    }
}
