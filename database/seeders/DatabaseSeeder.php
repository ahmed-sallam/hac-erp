<?php

namespace Database\Seeders;

use App\Models\Items;
use App\Models\Stores;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Countries;
use App\Models\Employees;
use App\Models\SubBrands;
use App\Models\Categories;
use App\Models\MainBrands;
use Illuminate\Session\Store;
use App\Models\StoreLocations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // SubBrands::truncate();
        // MainBrands::truncate();
        // Employees::truncate();
        // Items::truncate();
        // Categories::truncate();
        // Countries::truncate();
        // Stores::truncate();
        // StoreLocations::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        /////
        //         Employees::factory()->count(2)->create();
        //         Items::factory()->count(2)->create();
        ////
        $store1 = Stores::create([
            'city_ar' => '--',
            'city_en' => '--',
            'name_ar' => 'العملاء',
            'name_en' => 'Customers',
            'type' => 'virtual'
        ]);
        $store2 = Stores::create([
            'city_ar' => '--',
            'city_en' => '--',
            'name_ar' => 'الموردين',
            'name_en' => 'Vendors',
            'type' => 'virtual'
        ]);
        $store3 = Stores::create([
            'city_ar' => '--',
            'city_en' => '--',
            'name_ar' => 'سكراب',
            'name_en' => 'Scrap',
            'type' => 'virtual'
        ]);
        $store4 = Stores::create([
            'city_ar' => 'مكه',
            'city_en' => 'Mecca',
            'name_ar' => 'مخازن مكه',
            'name_en' => 'Mecca Stores',
            'type' => 'physical'
        ]);
        $store5 = Stores::create([
            'city_ar' => 'جدة',
            'city_en' => 'Jeddah',
            'name_ar' => 'مخازن جدة',
            'name_en' => 'Jeddah Stores',
            'type' => 'physical'
        ]);
        $mBrand1 = MainBrands::create([
            'name_ar' => 'كاتربيلر',
            'name_en' => 'Caterpillar',
        ]);
        $mBrand2 = MainBrands::create([
            'name_ar' => 'كوماتسو',
            'name_en' => 'Komatsu',
        ]);
        $mBrand3 = MainBrands::create([
            'name_ar' => 'هيتاشي',
            'name_en' => 'Hitachi',
        ]);

        $sBrand1 = SubBrands::create([
            'name_ar' => 'كات',
            'name_en' => 'CAT',
            'code' => 'CAT',
            'main_brand_id' => $mBrand1->id,
        ]);
        $sBrand2 = SubBrands::create([
            'name_ar' => 'كوماتسو فورست',
            'name_en' => 'Komatsu Forest',
            'code' => 'KF',
            'main_brand_id' => $mBrand2->id,
        ]);
        $sBrand3 = SubBrands::create([
            'name_ar' => 'كوماتسو مايننج',
            'name_en' => 'Komatsu Mining',
            'code' => 'KM',
            'main_brand_id' => $mBrand2->id,
        ]);
        $country1 = Countries::create([
            'name_ar' => 'الولايات المتحدة',
            'name_en' => 'United States',
        ]);
        $country2 = Countries::create([
            'name_ar' => 'المملكة المتحدة',
            'name_en' => 'United Kingdom',
        ]);
        $country3 = Countries::create([
            'name_ar' => 'كندا',
            'name_en' => 'Canada',
        ]);
        $country4 = Countries::create([
            'name_ar' => 'ألمانيا',
            'name_en' => 'Germany',
        ]);

        $employee1 = Employees::create([
            'name_ar' => 'محمد علي',
            'name_en' => 'Mohammad Ali',
            'gov_id' => 'GOV001',
            'joining_date' => now(),
            'country_id' => 1,
        ]);

        $employee2 = Employees::create([
            'name_ar' => 'فاطمة أحمد',
            'name_en' => 'Fatima Ahmed',
            'gov_id' => 'GOV002',
            'joining_date' => now(),
            'country_id' => 2,
        ]);

        $employee3 = Employees::create([
            'name_ar' => 'عبد الرحمن خالد',
            'name_en' => 'Abdulrahman Khaled',
            'gov_id' => 'GOV003',
            'joining_date' => now(),
            'country_id' => 3,
        ]);

        $employee4 = Employees::create([
            'name_ar' => 'نورهان مصطفى',
            'name_en' => 'Norhan Mostafa',
            'gov_id' => 'GOV004',
            'joining_date' => now(),
            'country_id' => 4,
        ]);
        $storeLocation1 = StoreLocations::create([
            'name_ar' => 'الأول',
            'name_en' => 'First',
            'store_id' => $store1->id, // Replace with an existing store ID
        ]);

        $storeLocation2 = StoreLocations::create([
            'name_ar' => 'الثاني',
            'name_en' => 'Second',
            'store_id' => $store2->id, // Replace with an existing store ID
        ]);

        $storeLocation3 = StoreLocations::create([
            'name_ar' => 'الثالث',
            'name_en' => 'Third',
            'store_id' => $store1->id, // Replace with an existing store ID
        ]);

        $storeLocation4 = StoreLocations::create([
            'name_ar' => 'الرابع',
            'name_en' => 'Fourth',
            'store_id' => $store3->id, // Replace with an existing store ID
        ]);

        $category1 = Categories::create([
            'name_ar' => 'محرك',
            'name_en' => 'Engine',
        ]);
        $category2 = Categories::create([
            'name_ar' => 'فلتر',
            'name_en' => 'Filter',
        ]);


        $item1 = Items::create([
            'item_number' => '203040',
            'description_ar' => 'وصف المنتج الأول',
            'description_en' => 'First Item Description',
            'req_min' => 1,
            'req_max' => 10,
            'is_set' => false,
            'is_original' => true,
            'item_image' => 'First Item Description Image',
            'unit_image' => 'First Item Unit Image',
            'main_brand_id' => 1, // Replace with an existing main brand ID
            'sub_brand_id' => 1, // Replace with an existing sub brand ID
            'category_id' => 1, // Replace with an existing category ID
            'country_id' => 1, // Replace with an existing country ID
            'is_active' => true,
            'sale_price' => 50.99,
            'cost_price' => 30.50,
        ]);

        $item2 = Items::create([
            'item_number' => '565638',
            'description_ar' => 'وصف المنتج الثاني',
            'description_en' => 'Second Item Description',
            'req_min' => 2,
            'req_max' => 20,
            'is_set' => true,
            'is_original' => true,
            'item_image' => 'Second Item Description Image',
            'unit_image' => 'Second Item Unit Image',
            'main_brand_id' => 2, // Replace with an existing main brand ID
            'sub_brand_id' => 2, // Replace with an existing sub brand ID
            'category_id' => 2, // Replace with an existing category ID
            'country_id' => 2, // Replace with an existing country ID
            'is_active' => true,
            'sale_price' => 75.50,
            'cost_price' => 45.25,
        ]);

        $item3 = Items::create([
            'item_number' => '565638',
            'description_ar' => 'وصف المنتج الثالث',
            'description_en' => 'Third Item Description',
            'req_min' => 3,
            'req_max' => 30,
            'is_set' => false,
            'is_original' => true,
            'item_image' => 'Third Item Description Image',
            'unit_image' => 'Third Item Unit Image',
            'main_brand_id' => 2, // Replace with an existing main brand ID
            'sub_brand_id' => 3, // Replace with an existing sub brand ID
            'category_id' => 2, // Replace with an existing category ID
            'country_id' => 3, // Replace with an existing country ID
            'is_active' => true,
            'sale_price' => 55.50,
            'cost_price' => 35.00,
        ]);

        $item4 = Items::create([
            'item_number' => 'ITM004',
            'description_ar' => 'وصف المنتج الرابع',
            'description_en' => 'Fourth Item Description',
            'req_min' => 4,
            'req_max' => 40,
            'is_set' => true,
            'is_original' => false,
            'item_image' => 'Fourth Item Description Image',
            'unit_image' => 'Fourth  Unit Image',
            'main_brand_id' => 1, // Replace with an existing main brand ID
            'sub_brand_id' => 1, // Replace with an existing sub brand ID
            'category_id' => 2, // Replace with an existing category ID
            'country_id' => 3, // Replace with an existing country ID
            'is_active' => true,
            'sale_price' => 20.50,
            'cost_price' => 5.25,
        ]);
    }
}
