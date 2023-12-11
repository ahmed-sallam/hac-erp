<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Country;
use App\Models\MainBrand;
use App\Models\Store;
use App\Models\StoreLocation;
use App\Models\SubBrand;
use App\Models\items;

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
            'item_number' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'description_ar' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'description_en' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'req_min' => $this->faker->randomNumber(),
            'req_max' => $this->faker->randomNumber(),
            'is_set' => $this->faker->boolean(),
            'is_original' => $this->faker->boolean(),
            'item_image' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'category_image' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'main_brand_id' => MainBrand::factory(),
            'sub_brand_id' => SubBrand::factory(),
            'category_id' => Category::factory(),
            'country_id' => Country::factory(),
            'store_id' => Store::factory(),
            'store_location_id' => StoreLocation::factory(),
        ];
    }
}
