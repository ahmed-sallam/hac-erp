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

        Schema::create('purchase_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number', 20)->unique();
            $table->date('quotation_date');
            $table->enum('status', ["pending","completed","rejected"]);
            $table->foreignId('material_request_id')->constrained();
            $table->foreignId('partner_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_quotations');
    }
};
