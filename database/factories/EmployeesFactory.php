<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\employees;

class EmployeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employees::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'name_en' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'gov_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'joining_date' => $this->faker->date(),
            'country_id' => Country::factory(),
        ];
    }
}
