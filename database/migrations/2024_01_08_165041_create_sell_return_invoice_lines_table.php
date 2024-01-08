<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sell_return_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('vat', 8, 2);
            $table->foreignId('item_id')->constrained();
            $table->foreignId('sell_return_invoice_id')->constrained();
            $table->foreignId('store_id')->constrained();
            $table->timestamps();
            $table->unique(['store_id', 'item_id', 'sell_return_invoice_id'], 'sell_return_invoice_lines_unique');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_return_invoice_lines');
    }
};
