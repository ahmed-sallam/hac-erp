<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Countries;
use Faker\Factory as Faker;

class CountriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Countries::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $arFaker = Faker::create('ar_SA');

        return [
            'name_ar' => $arFaker->realText(20),
            'name_en' => $this->faker->realText(20),
        ];
    }
}