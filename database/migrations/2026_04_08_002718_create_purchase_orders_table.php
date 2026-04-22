<?php

use App\Enums\PurchaseStatus;
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
        Schema::create('budget_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('budget', 15, 2);
            $table->timestamps();
    
            $table->unique(['start_date', 'end_date']);
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('budget_plan_id')
              ->constrained()
              ->cascadeOnDelete();

            $table->foreignId('menu_id')->nullable()->constrained('menus')->cascadeOnUpdate();

            $table->date('date'); // tanggal belanja (harian)
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->enum('status', PurchaseStatus::cases());
            $table->timestamps();
        });
        
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_order_id')
              ->constrained()
              ->cascadeOnDelete();

            // vendor per bahan (penting untuk dapur)
            $table->foreignId('vendor_id')
                    ->constrained('vendors');

            $table->foreignId('material_id')
                    ->constrained('materials');

            // jumlah beli
            $table->decimal('qty_display', 15, 3);

            // harga saat beli (untuk laporan & costing)
            $table->decimal('price', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('budget_plans');
    }
};
