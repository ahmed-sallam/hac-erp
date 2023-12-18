<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MaterialRequest;
use App\Models\Partner;
use App\Models\PurchaseQuotation;

class PurchaseQuotationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseQuotation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quotation_number' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'quotation_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["pending","completed","rejected"]),
            'material_request_id' => MaterialRequest::factory(),
            'partner_id' => Partner::factory(),
        ];
    }
}
