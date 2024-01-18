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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete()->cascadeOnUpdate();
            $table->double('price', 8, 2);
            $table->double('discount_value', 8, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_value', 10, 2)->default(0);
            $table->double('total_with_tax', 8, 2);
            $table->unsignedTinyInteger('type');
            $table->enum('invoice_status' , ['pending', 'review', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
