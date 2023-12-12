<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Countries;

class CountriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Countries::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'name_en' => $this->faker->regexify('[A-Za-z0-9]{20}'),
        ];
    }
}
