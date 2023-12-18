<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Item;
use App\Models\StockMovement;
use App\Models\Store;

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
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'movement_type' => $this->faker->randomElement(["in","out","transfer"]),
            'source_store_id' => Store::factory(),
            'destination_store_id' => Store::factory(),
            'item_id' => Item::factory(),
            'employee_id' => Employee::factory(),
        ];
    }
}
