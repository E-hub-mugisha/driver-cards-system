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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('ID_number')->unique();
            $table->string('driver_license')->unique();
            $table->string('phone')->unique();
            $table->string('rssb')->nullable();
            $table->enum('contract_type', ['permanent', 'temporary', 'internship'])->nullable();
            $table->string('insurance')->nullable();
            $table->string('photo')->nullable();
            $table->string('contract')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            // Company relation
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
