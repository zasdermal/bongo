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
        Schema::create('sale_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('territory_id')->nullable()->constrained('territories')->nullOnDelete();
            $table->string('name');
            $table->string('code_number')->unique();
            $table->text('address')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_number')->nullable();
            // $table->enum('pharmacy_type', ['General', 'Institute', 'Chain', 'Corporate'])->default('General');
            // $table->enum('payment_type', ['Cash', 'Credit', 'Partial Credit'])->default('Cash'); // credit type
            // $table->integer('credit_limit')->nullable(); // credit limit
            // $table->integer('credit_duration')->nullable(); // credit duration
            // $table->enum('sell_discount_type', ['TP', 'MRP'])->default('TP'); // discount type
            // $table->integer('sell_discount')->nullable(); // discount
            // $table->string('lat_lng')->nullable();
            $table->enum('is_active', ['Active', 'Inactive'])->default('Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_points');
    }
};
