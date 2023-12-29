<?php

namespace Database\Factories;

use App\Models\Partners;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SellInvoice;
use App\Models\SellQuotation;

class SellInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellInvoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'invoice_date' => $this->faker->date(),
            'delivery_date' => $this->faker->date(),
            'invoice_type' => $this->faker->randomElement(["cash","credit"]),
            'partner_id' => Partners::factory(),
            'sell_quotation_id' => SellQuotation::factory(),
            'discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'sub_total' => $this->faker->randomFloat(2, 0, 999999.99),
            'vat' => $this->faker->randomFloat(2, 0, 999999.99),
            'total' => $this->faker->randomFloat(2, 0, 999999.99),
        ];
    }
}
