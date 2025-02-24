<?php

namespace App\Services;

use App\Models\RecurrentExpenses;
/**
 * Will do the bridge between the models and the controller
 */
class RecurrentExpenseService
{
    public function getAll()
    {
        $totalCost = self::getSum();
        $recurrentExpenses = RecurrentExpenses::all()->map(function ($recurrentExpense) use ($totalCost) {
            $percentage = $totalCost > 0 ? ($recurrentExpense->cost / $totalCost) * 100 : 0;
            $recurrentExpense->percentage = number_format($percentage, 2);
            return $recurrentExpense;
        });
        return $recurrentExpenses;
    }

    public function getSum()
    {
        $recurrentExpensesSum = RecurrentExpenses::sum('cost');
        return $recurrentExpensesSum;
    }

    public function createRecurrentExpense($data)
    {
        $expense = RecurrentExpenses::create($data);
        return $expense;
    }

    public function storeMany($data){
        foreach ($data as $expenseData) {
            RecurrentExpenses::create($expenseData);
        }
    }

    public function update($data)
    {
        $recurrentExpense = RecurrentExpenses::find($data['id']);
        $recurrentExpense->update($data);

        return $recurrentExpense;
    }
}
