<?php

use App\Http\Controllers\Web\PaymentMethodController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\RecurrentExpenses;
use App\Http\Controllers\Web\ExpenseTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/', [DashboardController::class, 'index'])->name('monthly');
    Route::get('/recurring-expenses', [RecurrentExpenses::class, 'index'])->name('recurring-expenses');
    Route::get('/expenses-categories', [ExpenseTypeController::class, 'index'])->name('expenses-categories');
    Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods');
});

require __DIR__ . '/auth.php';
