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
        Schema::create('payroll_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                  ->constrained('companies')
                  ->cascadeOnDelete();

            $table->enum('salary_type', ['monthly','per_trip','hybrid'])->default('monthly');

            $table->decimal('base_salary',10,2)->nullable();
            $table->decimal('trip_rate',10,2)->nullable();
            $table->decimal('overtime_rate',10,2)->nullable();

            $table->decimal('rssb_rate',5,2)->default(0);  // Rwanda social security
            $table->decimal('tax_rate',5,2)->default(0);

            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_settings');
    }
};
