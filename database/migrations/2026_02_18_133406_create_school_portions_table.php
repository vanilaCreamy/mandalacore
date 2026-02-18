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
        Schema::create('school_portions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools', 'id')->cascadeOnUpdate();
            $table->integer('small_portions')->default(0);
            $table->integer('big_portions')->default(0);
            $table->integer('teacher_portions')->default(0);
            $table->integer('non_teacher_portions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_portions');
    }
};
