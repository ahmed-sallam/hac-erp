<?php

namespace Database\Seeders;

use App\Models\MainBrands;
use Illuminate\Database\Seeder;

class MainBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainBrands::factory()->count(5)->create();
    }
}
