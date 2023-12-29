<?php

namespace Database\Factories;

use App\Models\Items;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\StockMovement;
use App\Models\StockMovementLine;

class StockMovementLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockMovementLine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_id' => Items::factory(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'stock_movement_id' => StockMovement::factory(),
        ];
    }
}
