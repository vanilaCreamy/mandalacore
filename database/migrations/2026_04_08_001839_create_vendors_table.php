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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person');
            $table->string('phone');
            $table->text('address');
            $table->string('bank_name');
            $table->string('bank_account_number');
            $table->boolean('is_active');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('materials_vendors', function(Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors', 'id')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_vendors');
        Schema::dropIfExists('vendors');
    }
};
