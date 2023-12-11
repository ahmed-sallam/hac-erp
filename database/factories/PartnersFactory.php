<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Employee;
use App\Models\partners;

class PartnersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partners::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'name_en' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'partner_type' => $this->faker->randomElement(["supplier","customer"]),
            'mobile' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'email' => $this->faker->safeEmail(),
            'payment_type' => $this->faker->randomElement(["cash","credit"]),
            'credit_limit' => $this->faker->randomNumber(),
            'credit_period' => $this->faker->randomNumber(),
            'country_id' => Country::factory(),
            'employee_id' => Employee::factory(),
        ];
    }
}
