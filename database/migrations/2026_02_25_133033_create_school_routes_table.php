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
        Schema::create('school_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('distribution_routes', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained('schools', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('delivery_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_routes');
    }
};
