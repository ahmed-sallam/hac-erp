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

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_number', 25)->index();
            $table->string('description_ar', 255);
            $table->string('description_en', 255);
            $table->unsignedSmallInteger('req_min');
            $table->unsignedSmallInteger('req_max');
            $table->boolean('is_set');
            $table->boolean('is_original');
            $table->string('item_image', 255);
            $table->string('category_image', 255);
            $table->foreignId('main_brand_id')->constrained();
            $table->foreignId('sub_brand_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('country_id')->constrained();
            $table->foreignId('store_id')->constrained();
            $table->foreignId('store_location_id')->constrained();
            $table->unique(['item_number', 'main_brand_id', 'sub_brand_id', 'country_id']);
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
