<?php

use App\Enums\DriverCategory;
use App\Enums\DriverFlow;
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
        Schema::create('school_deliveries', function (Blueprint $table) {
            $table->id();
            $table->dateTime('timestamp');
            $table->foreignId('prev_log_id')->nullable()->constrained('school_deliveries', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('category', DriverCategory::cases());
            $table->enum('flow', DriverFlow::cases());
            $table->foreignId('school_id')->constrained('schools','id')->cascadeOnUpdate();
            $table->integer('amount_pk');
            $table->integer('amount_pb');
            $table->foreignId('driver_id')->constrained('users','id')->cascadeOnUpdate();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });

        Schema::create('posyandu_deliveries', function (Blueprint $table) {
            $table->id();
            $table->dateTime('timestamp');
            $table->foreignId('prev_log_id')->nullable()->constrained('posyandu_deliveries', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('category', DriverCategory::cases());
            $table->enum('flow', DriverFlow::cases());
            $table->foreignId('posyandu_id')->constrained('posyandu','id')->cascadeOnUpdate();
            $table->integer('amount_bumil');
            $table->integer('amount_busui');
            $table->integer('amount_balita');
            $table->foreignId('driver_id')->constrained('users','id')->cascadeOnUpdate();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_deliveries');
        Schema::dropIfExists('school_deliveries');
    }
};
