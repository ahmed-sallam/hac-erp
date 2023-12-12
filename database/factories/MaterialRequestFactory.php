<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employees;
use App\Models\MaterialRequest;
use App\Models\Stores;

class MaterialRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialRequest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'request_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["pending","approved","rejected"]),
            'store_id' => Stores::factory(),
            'employee_id' => Employees::factory(),
        ];
    }
}