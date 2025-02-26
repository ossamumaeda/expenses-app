<?php

namespace App\Services;

use App\Models\RecurrentExpenses;
/**
 * Will do the bridge between the models and the controller
 */
class RecurrentExpenseService
{
    public function getAll($user_id)
    {
        $totalCost = self::getSum($user_id);
        $recurrentExpenses = RecurrentExpenses::where('user_id', $user_id)
            ->get() // Fetch the data first
            ->map(function ($recurrentExpense) use ($totalCost) {
                $percentage = $totalCost > 0 ? ($recurrentExpense->cost / $totalCost) * 100 : 0;
                $recurrentExpense->percentage = number_format($percentage, 2);
                return $recurrentExpense;
            });

        return $recurrentExpenses;
    }

    public function getSum($user_id)
    {
        $recurrentExpensesSum = RecurrentExpenses::where('user_id', $user_id)->sum('cost');
        return $recurrentExpensesSum;
    }

    public function createRecurrentExpense($data, $user_id)
    {
        $data['user_id'] = $user_id;
        $expense = RecurrentExpenses::create($data);
        return $expense;
    }

    public function storeMany($data, $user_id)
    {
        foreach ($data as $expenseData) {
            $expenseData['user_id'] = $user_id;
            RecurrentExpenses::create($expenseData);
        }
    }

    public function update($data, $user_id)
    {
        $recurrentExpense = RecurrentExpenses::where('id', $data['id'])->where('user_id', $user_id)->first();
        $recurrentExpense->update($data);

        return $recurrentExpense;
    }
}
