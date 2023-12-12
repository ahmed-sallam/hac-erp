<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Stores;
use App\Models\StoreLocations;
use Faker\Factory as Faker;

class StoreLocationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreLocations::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $arFaker = Faker::create('ar_SA');

        return [
            'name_ar' => $arFaker->realText(10),
            'name_en' => $this->faker->realText(10),
            'store_id' => Stores::factory(),
        ];
    }
}