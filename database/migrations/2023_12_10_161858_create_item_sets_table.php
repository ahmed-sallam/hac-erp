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

        Schema::create('item_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_item_id')->constrained('items')->index();
            $table->foreignId('member_item_id')->constrained('items');
            $table->unsignedSmallInteger('quantity');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_sets');
    }
};
