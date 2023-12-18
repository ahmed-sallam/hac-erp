<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\PurchaseQuotation;
use App\Models\PurchaseQuotationLine;

class PurchaseQuotationLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseQuotationLine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'price' => $this->faker->randomFloat(2, 0, 999999.99),
            'vat' => $this->faker->randomFloat(2, 0, 999999.99),
            'item_id' => Item::factory(),
            'purchase_quotation_id' => PurchaseQuotation::factory(),
        ];
    }
}
