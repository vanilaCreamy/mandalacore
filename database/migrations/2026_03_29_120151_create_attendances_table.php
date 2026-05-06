<?php

use App\Enums\AttendanceStatus;
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnUpdate();
            $table->foreignId('recorded_by')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->date('date');
            $table->enum('status', AttendanceStatus::cases())->nullable();
            $table->timestamp('first_check_in')->nullable();
            $table->timestamp('last_check_out')->nullable();
            $table->integer('late_minutes')->default(0);
            $table->integer('work_minutes')->default(0);
            $table->boolean('is_overtime')->default(false);
            

            $table->timestamps();

            $table->unique(['user_id', 'date']);
            $table->index('date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
        Schema::dropIfExists('attendances');
    }
};
