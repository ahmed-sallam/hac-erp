<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sell_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->date('invoice_date');
            $table->date('delivery_date');
            $table->enum('invoice_type', ["cash","credit"]);
            $table->foreignId('partner_id')->constrained();
            $table->foreignId('sell_quotation_id')->constrained();
            $table->decimal('discount', 8, 2);
            $table->decimal('sub_total', 8, 2);
            $table->decimal('vat', 8, 2);
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_invoices');
    }
};
