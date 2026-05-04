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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_id')->constrained('materials');

            $table->enum('ref_type', [
                'RECEIPT',
                'USAGE',
                'ADJUSTMENT',
                'WASTE',
                'RETURN',
                'PRICE_ADJUSTMENT'
            ]);

            $table->unsignedBigInteger('ref_id');
            $table->date('date');

            $table->decimal('qty_in', 12, 2)->default(0);
            $table->decimal('qty_out', 12, 2)->default(0);
            $table->decimal('balance', 14, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
