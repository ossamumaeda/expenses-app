<?php

namespace Database\Factories;
use App\Models\ExpenseType;
use App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
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
            'due_date' => now(),
            'installments' => false,
            'expense_type_id' => ExpenseType::factory(), // Generate a related TypeOfExpense
            'payment_method_id' => PaymentMethod::factory(), // Generate a related TypeOfExpense
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
