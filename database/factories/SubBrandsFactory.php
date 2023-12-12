<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MainBrands;
use App\Models\SubBrands;
use Faker\Factory as Faker;


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
        $arFaker = Faker::create('ar_SA');

        return [
            'name_ar' => $arFaker->name,
            'name_en' => $this->faker->name,
            'code' => $this->faker->regexify('[A-Za-z0-9]{3}'),
            'main_brand_id' => MainBrands::factory(),
        ];
    }
}
