<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CustomerRequest;
use App\Models\CustomerRequestLine;
use App\Models\Items;
use App\Models\Stores;

class CustomerRequestLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerRequestLine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'store_id' => Stores::factory(),
            'customer_request_id' => CustomerRequest::factory(),
            'item_id' => Items::factory(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
