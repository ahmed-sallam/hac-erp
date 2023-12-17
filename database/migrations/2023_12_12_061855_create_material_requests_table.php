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

        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->unique();
            $table->date('request_date');
            $table->enum('status', ["pending","pricing","quotation","completed","rejected"]);
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('employee_id')->constrained('employees');
            $table->timestamps();

        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
