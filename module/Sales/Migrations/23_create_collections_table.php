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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_invoice_id')->constrained('order_invoices')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['Due', 'Paid', 'Partial Payment', 'Partial | Paid', 'Return'])->default('Due');
            $table->decimal('collection_amount', 10, 2);
            $table->decimal('addi_dis_amount', 10, 2)->nullable();
            $table->decimal('ait', 10, 2)->nullable();
            $table->decimal('return_amount', 10, 2)->nullable();
            $table->decimal('partial_paid', 10, 2)->nullable();
            $table->decimal('full_paid', 10, 2)->nullable();
            $table->decimal('due', 10, 2)->nullable();
            // $table->enum('money_receipt_status', ['done'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
