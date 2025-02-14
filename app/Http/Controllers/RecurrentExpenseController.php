<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Services\RecurrentExpenseService;

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
                'frequency' => 'string',
                'description' => 'string',

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
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Only read column A (index 0) and B (index 1)
            $columnA = isset($data[0]) ? $data[0] : '';
            $columnB = isset($data[1]) ? $data[1] : 0;
            $columnC = isset($data[2]) ? $data[2] : '';
    
            // Build response with column values
            $response[] = [
                'name' => $columnA,
                'cost' => $columnB,
                'description' => $columnC
            ]; 
            $row++;
        }
    
        fclose($handle);
        return response()->json($response);
    }
    
}
