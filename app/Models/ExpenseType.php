<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseType extends Model
{
    use HasFactory;

    protected $table = 'expense_types';
    protected $fillable = ['name', 'description','color','user_id'];
    public  $timestamps = true;
    
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_type_id');  // Foreign key 'type_of_expense_id'
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
