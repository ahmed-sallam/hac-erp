<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainBrands;
use App\Models\SubBrands;
use App\Models\Employees;
use App\Models\Items;
use App\Models\Categories;
use App\Models\Countries;
use App\Models\Stores;
use App\Models\StoreLocations;

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
        // Employees::factory()->count(5)->create();
        // Items::factory()->count(30)->create();

    }
}