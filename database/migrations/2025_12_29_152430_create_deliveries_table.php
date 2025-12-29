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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained();
            $table->date('delivery_date');

            // TBS Weight in kilograms
            $table->integer('weight_kg');

            // Quality metrics (0-100%)
            $table->decimal('bad_fruit_percentage', 5, 2);

            // Flags for quality control
            $table->boolean('is_over_capacity')->default(false);
            $table->boolean('needs_audit')->default(false);

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
