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
        Schema::table('incidents', function (Blueprint $table) {
            // Root Cause Analysis
            $table->enum('root_cause_category', [
                'human_error',
                'mechanical_failure',
                'environment',
                'policy_violation',
                'training_gap',
                'fatigue',
                'other'
            ])->nullable();

            $table->text('root_cause_details')->nullable();

            // Responsibility
            $table->enum('responsibility', [
                'driver',
                'company',
                'third_party',
                'shared',
                'unknown'
            ])->default('unknown');

            // Approval Workflow
            $table->enum('approval_status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->text('rejection_reason')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            //
        });
    }
};
