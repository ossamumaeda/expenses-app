<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $fillable = ['name', 'description','color'];
    public  $timestamps = true;
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'payment_method_id');  // Foreign key 'type_of_expense_id'
    }

}
