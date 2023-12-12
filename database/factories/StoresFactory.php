<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Stores;

class StoresFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stores::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'city_ar' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'city_en' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'name_ar' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'name_en' => $this->faker->regexify('[A-Za-z0-9]{25}'),
        ];
    }
}
