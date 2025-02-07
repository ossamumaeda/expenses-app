<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecurrentExpenses;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentMethodController;


Route::get('/', [DashboardController::class, 'index']);
Route::get('/recurring-expenses', [RecurrentExpenses::class, 'index']);
// Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
