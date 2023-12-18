<?php

namespace Database\Seeders;

use App\Models\PurchaseInvoice;
use Illuminate\Database\Seeder;

class PurchaseInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseInvoice::factory()->count(5)->create();
    }
}
