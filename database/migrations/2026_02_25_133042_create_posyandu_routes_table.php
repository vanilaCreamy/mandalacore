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
        Schema::create('posyandu_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('distribution_routes', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('posyandu_id')->constrained('posyandu', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('delivery_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_routes');
    }
};
