<?php

use App\enum\AttendanceStatus;
use App\enum\AttendanceType;
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
            $table->enum('status', AttendanceStatus::cases());
            $table->time('first_check_in')->nullable();
            $table->time('last_check_out')->nullable();
            $table->integer('late_minutes')->default(0);
            $table->integer('work_minutes')->default(0);

            $table->timestamps();

            $table->unique(['user_id', 'date']);
            $table->index('date');
            $table->index('status');
        });

        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('attendance_id')
                  ->constrained()
                  ->cascadeOnDelete();
        
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
        
            $table->timestamp('logged_at');
        
            $table->enum('type', AttendanceType::cases());
            $table->string('note')->nullable();
        
            $table->timestamps();
        
            $table->index('logged_at');
            $table->index('type');
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
