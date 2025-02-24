<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Services\RecurrentExpenseService;
use App\Http\Controllers\Controller;

class RecurrentExpenseController extends Controller
{
    protected $recurrentExpenseService;

    public function __construct(RecurrentExpenseService $recurrentExpenseService)
    {
        $this->recurrentExpenseService = $recurrentExpenseService;
    }

    public function store(Request $request)
    {
        $request->merge([
            'starting_date' => now(),
            'frequency' => 'monthly'
        ]);

        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'cost' => 'required|numeric',
                'color' => 'string',
                'frequency' => 'nullable|string',
                'description' => 'nullable|string|max:255',
            ]);
            $this->recurrentExpenseService->createRecurrentExpense($validated);
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

    public function update(Request $request)
    {
        try{
            $validated = $request->validate([
                'id' => 'numeric',
                'name' => 'string|max:255',
                'cost' => 'numeric',
                'description' => 'string|max:255'
            ]);
            $this->recurrentExpenseService->update($validated);
            if ($request->expectsJson() === false) {
                // Return the same view and reload the page with a success message
                return redirect()->back()->with('message', 'Record updated successfully!');
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
    
    public function createMany(Request $request)
    {
        $expenses = [];
        foreach ($request->expenses as $expenseData) {
            $expenseData['cost'] = (float) $expenseData['cost'];
            $expenseData['color'] = '#FFF';
            $expenseData['starting_date'] = now();
            $expenseData['frequency'] = 'monthly';
            $expenses[] = $expenseData;
        }

        // Update the request with the casted values
        $request->merge(['expenses' => $expenses]);
        // Validate the request data
        $request->validate([
            'expenses' => 'required|array',
            'expenses.*.name' => 'required|string|max:255',
            'expenses.*.cost' => 'required|numeric|min:0',
            'expenses.*.description' => 'string|max:255',
            'expenses.*.color' => 'string|max:20',
            'frequency' => 'nullable|string',
        ]);

        $this->recurrentExpenseService->storeMany($request->expenses);

        return response()->json(['message' => 'Recurrent expenses added successfully!'], 201);
    }

}
