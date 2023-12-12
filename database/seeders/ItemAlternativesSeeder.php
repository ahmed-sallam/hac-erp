<?php

namespace Database\Seeders;

use App\Models\ItemAlternatives;
use Illuminate\Database\Seeder;

class ItemAlternativesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemAlternatives::factory()->count(5)->create();
    }
}
