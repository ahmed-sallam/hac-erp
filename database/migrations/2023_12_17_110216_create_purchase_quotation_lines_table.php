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

        Schema::create('purchase_quotation_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('vat', 8, 2);
            $table->foreignId('item_id')->constrained();
            $table->foreignId('purchase_quotation_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_quotation_lines');
    }
};
