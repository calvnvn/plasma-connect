<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $weight = fake()->numberBetween(500, 4000); // Weight between 500kg and 4000kg
        $isOver = $weight > 3000; // Over capacity if weight > 2500kg
        return [
            'delivery_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'weight_kg' => $weight,
            'bad_fruit_percentage' => fake()->randomFloat(2, 0, 10), // Bad fruit percentage between 0% and 15%
            'is_over_capacity' => $isOver,
            'needs_audit' => $isOver || fake()->boolean(10), // 10% chance of needing audit if not over capacity
        ];
    }
}
