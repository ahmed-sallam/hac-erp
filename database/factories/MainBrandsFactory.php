<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MainBrands;
use Faker\Factory as Faker;
class MainBrandsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MainBrands::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $arFaker = Faker::create('ar_SA');
        return [
            'name_ar' => $arFaker->company,
            'name_en' => $this->faker->company,
        ];
    }
}
