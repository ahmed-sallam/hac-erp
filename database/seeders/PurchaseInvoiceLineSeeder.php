<?php

namespace Database\Seeders;

use App\Models\PurchaseInvoiceLine;
use Illuminate\Database\Seeder;

class PurchaseInvoiceLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseInvoiceLine::factory()->count(5)->create();
    }
}
