<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CustomerRequest;
use App\Models\Employees;
use App\Models\Partners;

class CustomerRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerRequest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'date' => $this->faker->date(),
            'partner_id' => Partners::factory(),
            'employee_id' => Employees::factory(),
        ];
    }
}
