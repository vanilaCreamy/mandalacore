<?php

use App\enum\DriverCategory;
use App\enum\DriverFlow;
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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->dateTime('timestamp');
            $table->enum('category', DriverCategory::cases());
            $table->enum('flow', DriverFlow::cases());
            $table->foreignId('school_id')->constrained('schools','id')->cascadeOnUpdate();
            $table->integer('amount');
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
        Schema::dropIfExists('deliveries');
    }
};
