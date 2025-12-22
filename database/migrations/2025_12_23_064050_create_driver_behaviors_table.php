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
        Schema::create('driver_behaviors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->cascadeOnDelete();


            $table->foreignId('behavior_type_id')
                ->constrained('behavior_types');


            $table->enum('severity', ['low', 'medium', 'high']);
            $table->integer('score');
            $table->date('behavior_date');
            $table->text('description')->nullable();


            $table->foreignId('reported_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_behaviors');
    }
};
