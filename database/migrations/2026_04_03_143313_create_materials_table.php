<?php

use App\Enums\MaterialMovType;
use App\Enums\OrderCategory;
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
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('abbr')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_category_id')->constrained('material_categories', 'id')->cascadeOnUpdate();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->decimal('qty_gram', 15, 3)->default(0);
            $table->string('display_unit');
            $table->decimal('conversion', 10, 3);
            $table->enum('order_category', OrderCategory::cases());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('material_categories');
    }
};
