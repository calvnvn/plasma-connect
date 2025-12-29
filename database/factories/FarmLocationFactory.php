<?php

namespace Database\Factories;
use App\Models\FarmLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FarmLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     * 
     * @return array<string, mixed>
     * 
     */
    public function definition(): array
    {
        // Pick a center point somewhere in Sumatra
        $centerLat = -0.5 + fake()->randomFloat(4, -0.1, 0.1);
        $centerLng = 101.5 + fake()->randomFloat(4, -0.1, 0.1);

        // Create a simple square polygon around the center point
        $polygon = [
            ['lat' => $centerLat + 0.001, 'lng' => $centerLng + 0.001],
            ['lat' => $centerLat + 0.001, 'lng' => $centerLng - 0.001],
            ['lat' => $centerLat - 0.001, 'lng' => $centerLng - 0.001],
            ['lat' => $centerLat - 0.001, 'lng' => $centerLng + 0.001],
        ];

        return [
            'center_lat' => $centerLat,
            'center_long' => $centerLng,
            'boundary_coordinates' => $polygon,
            'calculated_area_ha' => fake()->randomFloat(2, 1, 4),
        ];
    }
}
