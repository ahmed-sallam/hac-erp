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

        Schema::create('sell_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number', 20)->unique();
            $table->date('quotation_date');
            $table->enum('status', ["under_process", "completed", "rejected"]);
            $table->foreignId('partner_id')->constrained('partners');
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('customer_request_id')->nullable(true)->constrained('customer_requests');
            $table->longText('notes');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_quotations');
    }
};
