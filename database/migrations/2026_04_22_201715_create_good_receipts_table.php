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
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();

            $table->string('receipt_number')->nullable()->unique();

            $table->foreignId('po_id')->constrained('purchase_orders');

            $table->date('receipt_date');
            $table->text('note')->nullable();

            $table->enum('status', ['draft', 'posted', 'priced', 'cancelled'])
                ->default('draft');

            $table->timestamps();
        });

        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('receipt_id')->constrained('goods_receipts')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('material_id')->constrained('materials');

            $table->decimal('qty_ordered', 12, 2)->nullable();
            $table->decimal('qty_received', 12, 2);

            // harga boleh kosong dulu
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('subtotal', 14, 2)->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
        Schema::dropIfExists('good_receipts');
    }
};
