<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CustomerRequest;
use App\Models\Employeess;
use App\Models\Partner;
use App\Models\SellInvoice;
use App\Models\SellQuotation;
use App\Models\SellReturnInvoice;
use App\Models\StockMovement;

class SellReturnInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellReturnInvoice::class;

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
            'partner_id' => Partner::factory(),
            'employee_id' => Employeess::factory(),
            'sell_invoice_id' => SellInvoice::factory(),
            'customer_request_id' => CustomerRequest::factory(),
            'sell_quotation_id' => SellQuotation::factory(),
            'stock_movement_id' => StockMovement::factory(),
            'sub_total' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'total' => $this->faker->randomFloat(2, 0, 999999.99),
            'vat' => $this->faker->randomFloat(2, 0, 999999.99),
            'net_total' => $this->faker->randomFloat(2, 0, 999999.99),
            'notes' => $this->faker->text(),
        ];
    }
}
