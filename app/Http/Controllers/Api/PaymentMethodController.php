<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodService;
use Illuminate\Validation\ValidationException;

class PaymentMethodController extends Controller
{

    protected $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function index()
    {
        $payment_methods = $this->paymentMethodService->getAll();
        return response()->json($payment_methods); 
    }

    public function getById($id)
    {
        $paymentMethod = $this->paymentMethodService->findById($id);

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

        $paymentMethod = $this->paymentMethodService->store($validated);
        return response()->json($paymentMethod, 201);
    }

    public function update(Request $request)
    {
        try{
            $validated = $request->validate([
                'id' => 'numeric',
                'name' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255'
            ]);
            $this->paymentMethodService->update($validated);
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
}
