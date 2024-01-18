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
        Schema::create('patient_accounts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('receipt_id')->nullable()->constrained('receipt_accounts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('payment_id')->nullable()->constrained('payment_accounts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('debit',8,2)->default('0.00');
            $table->decimal('credit',8,2)->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_accounts');
    }
};
