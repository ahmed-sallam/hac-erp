<?php

namespace Database\Factories;

use App\Models\Employees;
use App\Models\Stores;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\StockMovement;

class StockMovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockMovement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'movement_type' => $this->faker->randomElement(["in","out","transfer"]),
            'source_store_id' => Stores::factory(),
            'destination_store_id' => Stores::factory(),
            'employee_id' => Employees::factory(),
            'movement_date' => $this->faker->date(),
            'reference' => $this->faker->regexify('[A-Za-z0-9]{20}'),
        ];
    }
}
