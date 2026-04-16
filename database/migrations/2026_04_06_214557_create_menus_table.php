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
        /**
         * 1) RECIPES
         */
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ayam Katsu
            $table->timestamps();
        });

        /**
         * 2) RECIPE MATERIALS (gramasi untuk 1 porsi standar / SD)
         */
        Schema::create('recipe_materials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();

            $table->decimal('qty_gram', 15, 3); // kebutuhan per 1 porsi SD

            $table->timestamps();
        });

        /**
         * 3) PORTION BASES (PK & PB)
         */
        Schema::create('portion_bases', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // PK, PB
            $table->string('name'); // Porsi Kecil, Porsi Besar
            $table->timestamps();
        });

        /**
         * 4) PORTION MATERIAL MULTIPLIERS
         * Aturan bahan mana yang beda gramasi untuk PK/PB
         */
        Schema::create('recipe_portion_bases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('portion_base_id')->constrained()->cascadeOnDelete();

            $table->decimal('multiplier', 5, 2); // contoh: nasi PK=0.7, PB=1.6

            $table->timestamps();
        });

        /**
         * 5) MENUS (menu harian)
         */
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Menu Senin, 14 April
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        /**
         * 6) MENU ITEMS (menu berisi resep apa saja)
         */
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

        /**
         * 7) MENU PORTIONS (jumlah anak PK & PB untuk menu tsb)
         */
        Schema::create('menu_portions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('portion_base_id')->constrained()->cascadeOnDelete();

            $table->integer('total_portions'); // jumlah anak

            $table->timestamps();
        });

        Schema::create('menu_extra_materials', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->foreignId('portion_base_id')->constrained()->cascadeOnDelete();
        
            // gram per 1 orang untuk porsi tsb
            $table->decimal('qty_gram', 15, 3);
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_extra_materials');
        Schema::dropIfExists('menu_portions');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('recipe_portion_bases');
        Schema::dropIfExists('portion_bases');
        Schema::dropIfExists('recipe_materials');
        Schema::dropIfExists('recipes');
    }
};
