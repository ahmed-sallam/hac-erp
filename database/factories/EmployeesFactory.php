<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Countries;
use App\Models\Employees;

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
            'name_ar' => $this->faker->realText(100),
            'name_en' => $this->faker->realText(100),
            'gov_id' => $this->faker->regexify('[0-9]{20}'),
            'joining_date' => $this->faker->date(),
            'country_id' => Countries::factory(),
        ];
    }
}