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
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('full_name');

            // Land precision agriculture details
            $table->decimal('land_area_ha', 5, 2);

            // calculation land area x standard yield per hectare
            $table->decimal('yield_capacity_limit', 8, 2)->nullable();

            // Farmer grading system
            $table->enum('status', ['active', 'suspended', 'blacklisted'])->default('active');
            $table->char('current_grade', 1)->default('B');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
