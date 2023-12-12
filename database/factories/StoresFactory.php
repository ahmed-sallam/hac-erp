<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Stores;
use Faker\Factory as Faker;

class StoresFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stores::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $arFaker = Faker::create('ar_SA');

        return [
            'city_ar' => $arFaker->realText(20),
            'city_en' => $this->faker->realText(25),
            'name_ar' => $arFaker->realText(20),
            'name_en' => $this->faker->realText(25),
        ];
    }
}