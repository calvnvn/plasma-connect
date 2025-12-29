<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FarmerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $landArea = fake()->randomFloat(2, 0.5, 10.0); // Land area between 0.5 and 10.0 hectares

        $maxYield = $landArea * 2.5; // Assuming standard yield per hectare is 2.5 TBS
        return [
            'nik' => fake()->unique()->numerify('16##00######00##'),
            'full_name' => fake()->name(),
            'land_area_ha' => $landArea,
            'yield_capacity_limit' => $maxYield,
            'status' => fake()->randomElement(['active', 'active', 'active', 'suspended']),
            'current_grade' => fake()->randomElement(['A', 'B', 'C']),
        ];
    }
}
