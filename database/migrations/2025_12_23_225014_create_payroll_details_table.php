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
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')
                  ->constrained('payrolls')
                  ->cascadeOnDelete();

            $table->foreignId('driver_id')
                  ->constrained('drivers')
                  ->cascadeOnDelete();

            // Earnings
            $table->decimal('base_amount',10,2)->default(0);
            $table->decimal('trips_earning',10,2)->default(0);
            $table->decimal('overtime_amount',10,2)->default(0);
            $table->decimal('bonus_amount',10,2)->default(0);

            // Deductions
            $table->decimal('penalty_amount',10,2)->default(0);
            $table->decimal('incident_deduction',10,2)->default(0);
            $table->decimal('tax_deduction',10,2)->default(0);
            $table->decimal('rssb_deduction',10,2)->default(0);

            // Totals
            $table->decimal('gross_salary',10,2)->default(0);
            $table->decimal('net_salary',10,2)->default(0);

            // Payment
            $table->enum('payment_status',['pending','paid'])->default('pending');
            $table->enum('payment_method',['bank','mobile_money','cash'])->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['payroll_id','driver_id']); // avoid duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};
