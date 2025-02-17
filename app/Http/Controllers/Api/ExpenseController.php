<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Services\ExpenseService;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        $expenses = Expense::with(['expenseType', 'paymentMethod'])->get();
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
        if (!$request->input('due_date')) {
            $request->merge([
                'due_date' => $request->input('date') . ' ' . $request->input('time') . ':00',
            ]);
        }

        try {
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
            return response()->json(
                [
                    'message' => 'Record created successfully!',
                    'data' => Expense::latest()->first(), // Optionally return the newly created data
                ],
                201,
            );
        } catch (ValidationException $e) {
            return response()->json(
                [
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ],
                422,
            );
        }
    }

    public function getByType()
    {
        $expenses = $this->expenseService->getByType();
        return response()->json($expenses);
    }

    public function uploadCsv(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048', // Adjust max size as needed
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Open the file for reading
        $handle = fopen($file->getRealPath(), 'r');

        $row = 1;
        $response = [];

        // Read each line of the CSV
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Only read column A (index 0) and B (index 1)
            $columnA = isset($data[0]) ? $data[0] : '';
            $columnB = isset($data[1]) ? $data[1] : 0;
            $columnC = isset($data[2]) ? $data[2] : '';

            // Build response with column values
            $response[] = [
                'name' => $columnA,
                'cost' => $columnB,
                'description' => $columnC,
            ];
            $row++;
        }

        fclose($handle);
        return response()->json($response);
    }

    public function createMany2(Request $request)
    {
        $request->validate([
            'expenses' => 'required|array',
            'expenses.*.name' => 'required|string|max:255',
            'expenses.*.cost' => 'required|numeric|min:0',
            'expenses.*.description' => 'string|max:255',
        ]);

        foreach ($request->expenses as $expenseData) {
            // Ensure the amount is a float
            $expenseData['cost'] = (float) $expenseData['cost'];
            Expense::create([
                'name' => $expenseData['name'],
                'description' => $expenseData['description'],
                'cost' => $expenseData['cost'],
            ]);
        }
    }

    public function createMany(Request $request)
    {
        $expenses = [];
        foreach ($request->expenses as $expenseData) {
            $expenseData['cost'] = (float) $expenseData['cost'];
            $expenseData['expense_type_id'] = 1;
            $expenseData['payment_method_id'] = 1;

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
        ]);

        // Insert each expense into the database
        foreach ($request->expenses as $expenseData) {
            Expense::create($expenseData);
        }

        return response()->json(['message' => 'Expenses added successfully!'], 201);
    }

    public function update(Request $request){
        try{
            $validated = $request->validate([
                'id' => 'required|numeric',
                'name' => 'string|max:255',
                'cost' => 'numeric',
                'description' => 'string|max:255',
                'expense_type_id' => 'required|numeric',
                'payment_method_id' => 'required|numeric'
            ]);

            $this->expenseService->update($validated);
            
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
}
