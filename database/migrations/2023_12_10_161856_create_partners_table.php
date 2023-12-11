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

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 100);
            $table->string('name_en', 100);
            $table->enum('partner_type', ["supplier","customer"]);
            $table->string('mobile', 20);
            $table->string('email', 150);
            $table->enum('payment_type', ["cash","credit"])->index();
            $table->unsignedInteger('credit_limit');
            $table->unsignedSmallInteger('credit_period');
            $table->foreignId('country_id')->constrained();
            $table->foreignId('employee_id')->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
