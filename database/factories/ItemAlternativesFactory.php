<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\item_alternatives;

class ItemAlternativesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemAlternatives::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_1_number' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'item_2_number' => $this->faker->regexify('[A-Za-z0-9]{25}'),
        ];
    }
}
