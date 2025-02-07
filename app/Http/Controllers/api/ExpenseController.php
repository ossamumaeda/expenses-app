<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        $expenses = Expense::with(['expenseType','paymentMethod'])->get();
        return response()->json($expenses); 
    }

    public function getById($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense type not found'], 404);
        }

        return response()->json($expense);
    }

    public function store(Request $request)
    {
        if(!$request->input('due_date')){
            $request->merge([
                'due_date' => $request->input('date') . ' ' . $request->input('time') . ':00'
            ]);
        }

        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'cost' => 'required|numeric',
                'installments' => 'bool',
                'due_date' => 'date|date_format:Y-m-d H:i:s',
                'expense_type_id' => 'required|exists:expense_types,id',
                'payment_method_id' => 'exists:payment_methods,id',
            ]);

            $expense = $this->expenseService->createExpense($validated);
            if ($request->expectsJson() === false) {
                // Return the same view and reload the page with a success message
                return redirect()->back()->with('message', 'Record created successfully!');
            }
        
            // If the request comes from an API (expects a JSON response)
            return response()->json([
                'message' => 'Record created successfully!',
                'data' => Expense::latest()->first() // Optionally return the newly created data
            ], 201);
        }
        catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function getByType(){
        $expenses = $this->expenseService->getByType();
        return response()->json($expenses); 
    }
}
