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
            $table->integer('small_portions');
            $table->integer('big_portions');
            $table->integer('teacher_portions');
            $table->integer('non_teacher_portions');
            $table->string('pic_name');
            $table->string('pic_position');
            $table->string('pic_phone_number');
            $table->string('pic_email');
            $table->string('hm_name');
            $table->string('hm_phone_number');
            $table->string('hm_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
