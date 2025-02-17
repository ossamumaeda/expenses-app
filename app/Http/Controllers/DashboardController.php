<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Services\ExpenseService;
use App\Services\ExpenseTypeService;
use App\Services\PaymentMethodService;


class DashboardController extends Controller
{
    protected $expenseService;
    protected $expenseTypeService;
    protected $paymentMethodService;

    public function __construct(ExpenseService $expenseService, ExpenseTypeService $expenseTypeService, PaymentMethodService $paymentMethodService)
    {
        $this->expenseService = $expenseService;
        $this->expenseTypeService = $expenseTypeService;
        $this->paymentMethodService = $paymentMethodService;
    }

    public function index()
    {
        // Retrieve data to populate the graph
        $expensesByType = $this->expenseService->getByType();
        $chartLabels = $expensesByType->pluck('name')->toArray(); // Labels
        $chartData = $expensesByType->pluck('cost')->toArray(); // Values
        $chartColor = $expensesByType->pluck('color')->toArray(); // Values

        // List of all the expenses
        $allExpenses = $this->expenseService->getAll();

        // Sum of the expenses
        $expensesTotalCost = $this->expenseService->getCostSum();

        // Get all the types of expenses
        $expenseTypes = $this->expenseTypeService->getAll();
        // Get all the payment methods
        $paymentMethods = $this->paymentMethodService->getAll();

        // dd($expensesByType);

        return view('dashboard', compact('chartLabels', 'chartData', 'chartColor', 'allExpenses', 'expensesByType','expenseTypes','expensesTotalCost','paymentMethods'));
    }

    public function createMany(){
        
    }


}
