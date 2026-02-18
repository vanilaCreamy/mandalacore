<?php

use App\enum\SchoolLevel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_code',50);
            $table->string('school_name',150);
            $table->text('address');
            $table->enum('school_level', SchoolLevel::cases());
            $table->string('pic_name');
            $table->string('pic_position')->nullable();
            $table->string('pic_phone_number')->nullable();
            $table->string('pic_email')->nullable();
            $table->string('hm_name')->nullable();
            $table->string('hm_phone_number')->nullable();
            $table->string('hm_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

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
        Schema::dropIfExists('schools');
    }
};
