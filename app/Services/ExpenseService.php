<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\RecurrentExpenses;
use Illuminate\Support\Facades\Auth;

/**
 * Will do the bridge between the models and the controller
 */
class ExpenseService {
    
    public function getByMonth(){
        $month = date('n');
        $year = date('Y');

        $expenses = Expense::whereYear('due_date', $year)
        ->whereMonth('due_date', $month)
        ->get();

        return $expenses;
    }

    public function getById($id){
        return Expense::find($id);
    }

    public function getByType(){
        $totalCost = self::getCostSum(); // Get total cost

        // Main query: Sum expenses grouped by expense type
        $expensesQuery = Expense::join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->selectRaw('expense_types.name AS name, SUM(expenses.cost) AS cost, expense_types.color as color')
            ->groupBy('expense_types.id', 'expense_types.name', 'expense_types.color');
        
        // Separate query: Sum of costs from the unrelated table
        $additionalCostsQuery = RecurrentExpenses::selectRaw('"Recurrent expenses" AS name, SUM(cost) AS cost, "green" AS color'); // Customize label and color
        
        // Combine using union
        $expenses = $expensesQuery->union($additionalCostsQuery)->get()
            ->map(function ($expense) use ($totalCost) {
                $percentage = ($totalCost > 0) ? ($expense->cost / $totalCost) * 100 : 0;
                $expense->percentage = number_format($percentage, 2);
                return $expense;
            });
        

        return $expenses;
    }

    public function getWithJoins(){
        return Expense::with(['expenseType', 'paymentMethod'])->get();
    }

    public function update($data)
    {
        $expense = Expense::find($data['id']);
        $expense->update($data);

        return $expense;
    }

    public function getAll(){
        $expenses = Expense::with(['expenseType','paymentMethod'])->get();
        return $expenses;
    }

    public function createExpense($data)
    {
        $expense = Expense::create($data);
    
        return $expense->load(['expenseType', 'paymentMethod']);
    }
    

    public function createMany($data){
        foreach ($data as $expenseData) {
            Expense::create($expenseData);
        }
    }

    public function getCostSum(){
        $totalCost = Expense::sum('cost');
        return $totalCost;
    }
}