<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Categories;
use App\Models\Countries;
use App\Models\MainBrands;
use App\Models\Stores;
use App\Models\StoreLocations;
use App\Models\SubBrands;
use App\Models\Items;

class ItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Items::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_number' => $this->faker->regexify('[0-9]{25}'),
            'description_ar' => $this->faker->realText(255),
            'description_en' => $this->faker->realText(255),
            'req_min' => $this->faker->numberBetween($min = 5, $max = 100),
            'req_max' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'is_set' => $this->faker->boolean(),
            'is_original' => $this->faker->boolean(),
            'item_image' => $this->faker->realText(255),
            'category_image' => $this->faker->realText(255),
            'main_brand_id' => MainBrands::factory(),
            'sub_brand_id' => SubBrands::factory(),
            'category_id' => Categories::factory(),
            'country_id' => Countries::factory(),
            'store_id' => Stores::factory(),
            'store_location_id' => StoreLocations::factory(),

        ];
    }
}
