<?php

namespace App\Http\Controllers\Api;

use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExpenseTypeService;
use Illuminate\Validation\ValidationException;

class ExpenseTypeController extends Controller
{
    protected $expenseTypeService;

    public function __construct(ExpenseTypeService $expenseTypeService)
    {
        $this->expenseTypeService = $expenseTypeService;
    }

    public function index()
    {
        $types = ExpenseType::all();
        // return view('types.index', compact('types'));
        return response()->json($types); 
    }

    public function getById($id)
    {
        $expenseType = ExpenseType::find($id);

        if (!$expenseType) {
            return response()->json(['message' => 'Expense type not found'], 404);
        }

        return response()->json($expenseType);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255'
        ]);

        $expenseType = ExpenseType::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        return response()->json($expenseType, 201);
    }

    public function edit($id)
    {
        $type = ExpenseType::findOrFail($id);
        return view('types.edit', compact('type'));
    }

    public function update(Request $request)
    {
        try{
            $validated = $request->validate([
                'id' => 'numeric',
                'name' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255'
            ]);
            $this->expenseTypeService->update($validated);
            if ($request->expectsJson() === false) {
                // Return the same view and reload the page with a success message
                return redirect()->back()->with('message', 'Record updated successfully!');
            }
        
            // If the request comes from an API (expects a JSON response)
            return response()->json([
                'message' => 'Record created successfully!'
            ], 201);
        }
        catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy($id)
    {
        $type = ExpenseType::findOrFail($id);
        $type->delete();
        return redirect()->route('types.index');
    }
}
