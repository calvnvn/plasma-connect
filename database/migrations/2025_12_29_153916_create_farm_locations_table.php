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
        Schema::create('farm_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained()->cascadeOnDelete();

            // Mid point coordinates of the farm location
            $table->double('center_lat');
            $table->double('center_long');

            // Boundary coordinates as GeoJSON
            $table->json('boundary_coordinates');

            // Calculated area in hectares (As comparison to farmer's reported land area)
            $table->decimal('calculated_area_ha', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_locations');
    }
};
