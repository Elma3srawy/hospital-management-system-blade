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
        Schema::create('service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("service_id")->constrained("services")->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("name")->unique();
            $table->string('locale' , 11)->index();
            $table->unique(['name','locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_translations');
    }
};
