<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\RecurrentExpenses;
use Illuminate\Support\Facades\Auth;

/**
 * Will do the bridge between the models and the controller
 */
class ExpenseService {
    
    public function getByMonth($user_id){
        $month = date('n');
        $year = date('Y');

        $expenses = Expense::whereYear('due_date', $year)
        ->whereMonth('due_date', $month)
        ->where('user_id',$user_id)
        ->get();

        return $expenses;
    }

    public function getById($id, $user_id)
    {
        return Expense::where('id', $id)->where('user_id', $user_id)->first();
    }

    public function getByType($user_id){
        $totalCost = self::getCostSum($user_id); // Get total cost

        // Main query: Sum expenses grouped by expense type
        $expensesQuery = Expense::join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->selectRaw('expense_types.name AS name, SUM(expenses.cost) AS cost, expense_types.color as color')
            ->where('expenses.user_id',$user_id)
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

    public function getWithJoins($user_id){
        return Expense::with(['expenseType', 'paymentMethod'])->get()->where('user_id',$user_id);
    }

    public function update($data,$user_id)
    {
        $expense = Expense::where('id', $data['id'])->where('user_id', $user_id)->first();
        $expense->update($data);

        return $expense;
    }

    public function getAll($user_id){
        $expenses = Expense::with(['expenseType','paymentMethod'])->get()->where('user_id',$user_id);
        return $expenses;
    }

    public function createExpense($data,$user_id)
    {   
        $data['user_id'] = $user_id;
        $expense = Expense::create($data);
    
        return $expense->load(['expenseType', 'paymentMethod']);
    }
    

    public function createMany($data,$user_id){
        foreach ($data as $expenseData) {
            $expenseData['user_id'] = $user_id;
            Expense::create($expenseData);
        }
    }

    public function getCostSum($user_id){
        $totalCost = Expense::where('user_id',$user_id)->sum('cost');
        return $totalCost;
    }
}