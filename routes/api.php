<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\RecurrentExpenseController;
use Illuminate\Http\Request;

Route::get('/types',[ExpenseTypeController::class,'index']);
Route::get('/types/{id}',[ExpenseTypeController::class,'getById']);
Route::post('/types', [ExpenseTypeController::class, 'store']);

Route::get('/payment_methods',[PaymentMethodController::class,'index']);
Route::get('/payment_methods/{id}',[PaymentMethodController::class,'getById']);
Route::post('/payment_methods', [PaymentMethodController::class, 'store']);

Route::get('/expenses',[ExpenseController::class,'index'])->name('expenses.index');
Route::get('/expenses/{id}',[ExpenseController::class,'getById']);
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

Route::post('/recurrent-expenses', [RecurrentExpenseController::class, 'store'])->name('recurrent-expenses.store');
Route::post('/recurrent-expenses-update', [RecurrentExpenseController::class, 'update'])->name('recurrent-expenses.update');

Route::post('/upload-csv', [RecurrentExpenseController::class, 'uploadCsv'])->name('recurrent-expenses.csv');
