<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Items;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestLine;

class MaterialRequestLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialRequestLine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'item_id' => Items::factory(),
            'material_request_id' => MaterialRequest::factory(),
        ];
    }
}