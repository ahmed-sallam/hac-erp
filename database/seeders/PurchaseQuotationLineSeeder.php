<?php

namespace Database\Seeders;

use App\Models\PurchaseQuotationLine;
use Illuminate\Database\Seeder;

class PurchaseQuotationLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseQuotationLine::factory()->count(5)->create();
    }
}
