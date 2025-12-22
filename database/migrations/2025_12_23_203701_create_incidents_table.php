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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['accident', 'traffic_violation', 'complaint', 'vehicle_damage', 'other']);
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->date('incident_date');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('evidence')->nullable(); // file upload
            $table->foreignId('reported_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->integer('impact_score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
