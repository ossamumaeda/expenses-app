<?php

namespace App\Services;

use App\Models\ExpenseType;
/**
 * Will do the bridge between the models and the controller
 */
class ExpenseTypeService
{
    public function getAll()
    {
        $expenseTypes = ExpenseType::all('id', 'name', 'color');
        return $expenseTypes;
    }

    public function update($data)
    {
        $expenseType = ExpenseType::find($data['id']);
        $expenseType->update($data);

        return $expenseType;
    }
    public function getById($id)
    {
        return ExpenseType::find($id);
    }

    public function store($data)
    {
        return ExpenseType::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'color' => $data['color']
        ]);
    }

    public function destroy($id){
        $type = ExpenseType::findOrFail($id);
        $type->delete();
    }
}
