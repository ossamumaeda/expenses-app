<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = PaymentMethod::all();
        return response()->json($payment_methods); 
    }

    public function getById($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if (!$paymentMethod) {
            return response()->json(['message' => 'Expense type not found'], 404);
        }

        return response()->json($paymentMethod);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255'
        ]);

        $paymentMethod = PaymentMethod::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        return response()->json($paymentMethod, 201);
    }
}
