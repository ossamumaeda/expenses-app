<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Models\Expense;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Services\RecurrentExpenseService;
use Illuminate\Support\Facades\Auth;

class RecurrentExpenses extends Controller
{
    protected $recurrentExpenseService;

    public function __construct(RecurrentExpenseService $recurrentExpenseService)
    {
        $this->recurrentExpenseService = $recurrentExpenseService;
    }

    public function index()
    {
        $user_id = $user_id = Auth::user()->id;
        $recurrentExpenses = $this->recurrentExpenseService->getAll($user_id);
        $recurrentExpensesSum =  $this->recurrentExpenseService->getSum($user_id);

        $chartLabels = $recurrentExpenses->pluck('name')->toArray(); // Labels
        $chartData = $recurrentExpenses->pluck('cost')->toArray(); // Values
        $chartColor = $recurrentExpenses->pluck('color')->toArray(); // Values

        return view('recurringExpenses.index', compact('recurrentExpenses','recurrentExpensesSum','chartLabels','chartData', 'chartColor'));
    }
}
