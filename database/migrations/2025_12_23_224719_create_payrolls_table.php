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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                  ->constrained('companies')
                  ->cascadeOnDelete();

            $table->date('month');   // store month as date (1st of month recommended)

            $table->enum('status', ['pending','processed','approved','paid'])
                  ->default('pending');

            $table->foreignId('processed_by')->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('approved_by')->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->unique(['company_id','month']);  // prevent duplicate payroll
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
