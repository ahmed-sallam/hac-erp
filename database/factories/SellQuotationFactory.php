<?php

namespace Database\Factories;

use App\Models\Partners;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SellQuotation;

class SellQuotationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellQuotation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quotation_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'quotation_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["under"]),
            'partner_id' => Partners::factory(),
        ];
    }
}
