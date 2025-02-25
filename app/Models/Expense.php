<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    protected $fillable = ['name', 'cost', 'expense_type_id', 'payment_method_id', 'installments', 'due_date','user_id'];
    protected $attributes = [
        'installments' => false,
    ];
    public $timestamps = true;

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    // Define the accessor for the 'due_date' field
    public function getDueDateAttribute($value)
    {
        // You can format the date however you'd like
        return Carbon::parse($value)->format('d/m/Y'); // Example: 'DD-MM-YYYY HH:MM:SS'
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
