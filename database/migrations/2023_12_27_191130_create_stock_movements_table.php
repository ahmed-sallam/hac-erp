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

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('movement_type', ["sale", "sale_return", "transfer", "purchase", "purchase_return", "scrap"]);
            $table->foreignId('source_store_id')->constrained('stores');
            $table->foreignId('destination_store_id')->constrained('stores');
            $table->foreignId('employee_id')->constrained('employees');
            $table->date('movement_date');
            $table->string('reference', 20)->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
