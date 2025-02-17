<?php

namespace App\Http\Controllers\Api;

use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseTypeController extends Controller
{
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $type = ExpenseType::findOrFail($id);
        $type->update($request->all());
        return redirect()->route('types.index');
    }

    public function destroy($id)
    {
        $type = ExpenseType::findOrFail($id);
        $type->delete();
        return redirect()->route('types.index');
    }
}
