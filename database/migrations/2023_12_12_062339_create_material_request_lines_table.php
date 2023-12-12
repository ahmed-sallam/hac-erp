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

        Schema::create('material_request_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->foreignId('item_id')->constrained('Items');
            $table->foreignId('material_request_id')->constrained('MaterialRequests');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_request_lines');
    }
};
