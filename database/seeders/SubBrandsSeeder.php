<?php

namespace Database\Seeders;

use App\Models\SubBrands;
use Illuminate\Database\Seeder;

class SubBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubBrands::factory()->count(5)->create();
    }
}
