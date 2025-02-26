<?php

use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ExpenseTypeController;
use App\Http\Controllers\Api\RecurrentExpenseController;
use App\Http\Controllers\Auth\TokenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    });
    Route::get('/user', function (Request $request) {
        // Is not redirecting
        return response()->json($request->user(), 201);
    });

    Route::post('/types', [ExpenseTypeController::class, 'store'])->name('types.store');
    Route::get('/types', [ExpenseTypeController::class, 'index']);
    Route::get('/types/{id}', [ExpenseTypeController::class, 'getById']);
    Route::post('/types-update', [ExpenseTypeController::class, 'update']);

    Route::get('/payment_methods', [PaymentMethodController::class, 'index']);
    Route::get('/payment_methods/{id}', [PaymentMethodController::class, 'getById']);
    Route::post('/payment_methods', [PaymentMethodController::class, 'store'])->name('payment-method.store');
    Route::post('/payment-update', [PaymentMethodController::class, 'update']);

    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/{id}', [ExpenseController::class, 'getById']);
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/upload-csv', [ExpenseController::class, 'uploadCsv'])->name('expenses.csv');
    Route::post('/expenses-update', [ExpenseController::class, 'update'])->name('expenses.update');

    Route::post('/expenses-create', [ExpenseController::class, 'createMany'])->name('expenses.store-many');

    Route::post('/recurrent-expenses', [RecurrentExpenseController::class, 'store'])->name('recurrent-expenses.store');
    Route::post('/recurrent-expenses-update', [RecurrentExpenseController::class, 'update'])->name('recurrent-expenses.update');

    Route::post('/recurrent-create', [RecurrentExpenseController::class, 'createMany'])->name('recurrent-expenses.store-many');
    Route::post('/destroy-token', [TokenController::class, 'destroyToken'])->name('create-token.destroyToken');
});

Route::post('/create-token', [TokenController::class, 'createToken'])->name('create-token.createToken');
