<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\PurchaseInvoice;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 999999.99),
            'date' => $this->faker->date(),
            'label' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'payment_method' => $this->faker->randomElement(["cash","bank"]),
            'purchase_invoice_id' => Partner::factory(),
            'partner_id' => PurchaseInvoice::factory(),
        ];
    }
}
