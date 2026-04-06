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
            $table->string('base_unit')->default('gram');
            $table->string('display_unit');
            $table->decimal('conversion', 10, 3);
            $table->enum('order_category', OrderCategory::cases());
            $table->timestamps();
        });
        Schema::create('material_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials', 'id')->cascadeOnUpdate();
            $table->decimal('qty_gram', 15, 3)->default(0);
            $table->timestamps();
        });
        Schema::create('material_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials', 'id')->cascadeOnUpdate();
            $table->enum('type', MaterialMovType::cases());
            $table->decimal('qty_gram', 15, 3);
            $table->nullableMorphs('reference');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_movements');
        Schema::dropIfExists('material_stocks');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('material_categories');
    }
};
