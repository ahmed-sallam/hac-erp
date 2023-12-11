<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MainBrand;
use App\Models\sub_brands;

class SubBrandsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubBrands::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'name_en' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'code' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'main_brand_id' => MainBrand::factory(),
        ];
    }
}
