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
        Schema::create('behavior_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('behavior_category_id')->constrained('behavior_categories')->cascadeOnDelete();
            $table->string('name');
            $table->enum('category', ['positive', 'negative']);
            $table->enum('severity', ['low', 'medium', 'high']);
            $table->integer('default_score');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('behavior_types');
    }
};
