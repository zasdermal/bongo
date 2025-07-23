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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('designations')->nullOnDelete();
            $table->foreignId('zone_id')->nullable()->unique()->constrained('zones')->nullOnDelete();
            $table->foreignId('division_id')->nullable()->unique()->constrained('divisions')->nullOnDelete();
            $table->foreignId('region_id')->nullable()->unique()->constrained('regions')->nullOnDelete();
            $table->foreignId('area_id')->nullable()->unique()->constrained('areas')->nullOnDelete();
            $table->foreignId('territory_id')->nullable()->unique()->constrained('territories')->nullOnDelete();
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
