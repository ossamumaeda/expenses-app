<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecurrentExpensesFactory extends Factory
{
     /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'cost' => $this->faker->randomFloat(2, 10, 1000), // Amount between 10 and 1000
            'description' => $this->faker->word(),
            'color' => $this->faker->colorName(),
            'frequency' => 'monthly',
            'start_date' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
