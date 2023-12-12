<?php

namespace Database\Seeders;

use App\Models\Stores;
use Illuminate\Database\Seeder;

class StoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stores::factory()->count(5)->create();
    }
}
