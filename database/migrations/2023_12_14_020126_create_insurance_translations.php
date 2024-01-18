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
        Schema::create('insurance_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id')->constrained('insurances')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('notes');
            $table->string('locale', 11)->index();
            $table->unique(['locale','name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_translations');
    }
};
