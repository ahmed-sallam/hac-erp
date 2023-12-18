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

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->enum('movement_type', ["in","out","transfer"]);
            $table->foreignId('source_store_id')->constrained('Stores');
            $table->foreignId('destination_store_id')->constrained('Stores');
            $table->foreignId('item_id')->constrained();
            $table->foreignId('employee_id')->constrained('Employees');
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
