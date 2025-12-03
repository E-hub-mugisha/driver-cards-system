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
            $table->string('ID_number');
            $table->string('driver_license');
            $table->string('phone');
            $table->string('rssb');
            $table->string('company');
            $table->string('contract_type');
            $table->string('Insurance');
            $table->string('photo');
            $table->string('contract');
            $table->string('status');
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->foreign('company_id')
                ->references('id')
                ->on('users');
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
