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
        Schema::create('doctor_translations', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->string('locale' , 11)->index();
            // $table->string('appointment')->nullable();
            // $table->unique(['doctor_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_translations');
    }
};
