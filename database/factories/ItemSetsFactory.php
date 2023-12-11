<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\item_sets;

class ItemSetsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemSets::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'set_item_id' => Item::factory(),
            'member_item_id' => Item::factory(),
            'quantity' => $this->faker->randomNumber(),
        ];
    }
}
