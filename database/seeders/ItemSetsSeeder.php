<?php

namespace Database\Seeders;

use App\Models\ItemSets;
use Illuminate\Database\Seeder;

class ItemSetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemSets::factory()->count(5)->create();
    }
}
