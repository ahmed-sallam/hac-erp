<?php

namespace Database\Seeders;

use App\Models\PurchaseQuotation;
use Illuminate\Database\Seeder;

class PurchaseQuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseQuotation::factory()->count(5)->create();
    }
}
