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

        Schema::create('customer_request_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained();
            $table->foreignId('customer_request_id')->constrained('customer_requests');
            $table->foreignId('item_id')->constrained('items');
            $table->unsignedInteger('quantity');
            $table->timestamps();
            $table->unique(['store_id', 'item_id', 'customer_request_id'], 'customer_request_lines_unique');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_request_lines');
    }
};
