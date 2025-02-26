<?php

namespace App\Services;

use App\Models\ExpenseType;
use Illuminate\Support\Facades\Auth;

/**
 * Will do the bridge between the models and the controller
 */
class ExpenseTypeService
{
    public function getAll($user_id)
    {
        $expenseTypes = ExpenseType::where('user_id', $user_id)->get(['id', 'name', 'color']);
        return $expenseTypes;
    }

    public function update($data, $user_id)
    {
        $expenseType = ExpenseType::where('id', $data['id'])->where('user_id', $user_id)->first();
        $expenseType->update($data);

        return $expenseType;
    }
    public function getById($id, $user_id)
    {
        return ExpenseType::where('id', $id)->where('user_id', $user_id)->first();
    }

    public function store($data, $user_id)
    {
        return ExpenseType::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'color' => $data['color'],
            'user_id' => $user_id,
        ]);
    }

    public function destroy($id, $user_id)
    {
        $type = ExpenseType::where('id', $id)->where('user_id', $user_id)->firstOrFail();

        $type->delete();
    }
}
