<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\RecurrentExpenses;
use App\Http\Controllers\Web\ExpenseTypeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'index']);
Route::get('/recurring-expenses', [RecurrentExpenses::class, 'index']);
Route::get('/expenses-categories', [ExpenseTypeController::class, 'index']);
// Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
