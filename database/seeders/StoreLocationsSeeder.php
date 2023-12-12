<?php

namespace Database\Seeders;

use App\Models\StoreLocations;
use Illuminate\Database\Seeder;

class StoreLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreLocations::factory()->count(5)->create();
    }
}
