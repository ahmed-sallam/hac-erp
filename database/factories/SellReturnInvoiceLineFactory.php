<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\SellReturnInvoice;
use App\Models\SellReturnInvoiceLine;
use App\Models\Store;

class SellReturnInvoiceLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellReturnInvoiceLine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(),
            'price' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'vat' => $this->faker->randomFloat(2, 0, 999999.99),
            'item_id' => Item::factory(),
            'sell_return_invoice_id' => SellReturnInvoice::factory(),
            'store_id' => Store::factory(),
        ];
    }
}
