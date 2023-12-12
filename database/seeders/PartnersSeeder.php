<?php

namespace Database\Seeders;

use App\Models\Partners;
use Illuminate\Database\Seeder;

class PartnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partners::factory()->count(5)->create();
    }
}
