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
        Schema::create('posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('posyandu_code',100);
            $table->string('posyandu_name',150);
            $table->text('address');
            $table->string('cadre_name');
            $table->string('cadre_phone_number')->nullable();
            $table->string('cadre_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posyandu_portions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posyandu_id')->constrained('posyandu', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('bumil')->default(0);
            $table->integer('busui')->default(0);
            $table->integer('balita')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_portions');
        Schema::dropIfExists('posyandu');
    }
};
