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

        Schema::create('sell_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->date('invoice_date');
            $table->date('delivery_date');
            $table->enum('invoice_type', ["cash", "credit"]);
            $table->foreignId('partner_id')->constrained('partners');
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('customer_request_id')->nullable(true)->constrained('customer_requests');
            $table->foreignId('sell_quotation_id')->nullable(true)->constrained('sell_quotations');
            $table->foreignId('stock_movement_id')->nullable(true)->constrained('stock_movements');
            $table->decimal('sub_total', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('vat', 8, 2);
            $table->decimal('net_total', 8, 2);
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
        Schema::dropIfExists('sell_invoices');
    }
};
