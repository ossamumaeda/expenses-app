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

    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $types = $this->expenseTypeService->getAll($user_id);
        // return view('types.index', compact('types'));
        return response()->json($types);
    }

    public function getById(Request $request)
    {
        $id = $request->route('id');
        $user_id = $request->user()->id;
        $expenseType = $this->expenseTypeService->getById($id,$user_id);

        if (!$expenseType) {
            return response()->json(['message' => 'Expense type not found'], 404);
        }

        return response()->json($expenseType);
    }

    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'color' => 'string'
        ]);
        $validated['user_id'] = $request->user()->id;
        $expenseType = $this->expenseTypeService->store($validated,$user_id);
        return response()->json($expenseType, 201);
    }

    public function update(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $validated = $request->validate([
                'id' => 'numeric',
                'name' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255',
            ]);
            $this->expenseTypeService->update($validated,$user_id);
            if ($request->expectsJson() === false) {
                // Return the same view and reload the page with a success message
                return redirect()->back()->with('message', 'Record updated successfully!');
            }

            // If the request comes from an API (expects a JSON response)
            return response()->json(
                [
                    'message' => 'Record created successfully!',
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

    public function destroy(Request $request)
    {
        $id = $request->route('id');
        $user_id = $request->user()->id;
        $this->expenseTypeService->destroy($id,$user_id);
        return redirect()->route('types.index');
    }
}
