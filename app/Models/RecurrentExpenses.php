<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecurrentExpenses extends Model
{
    use HasFactory;

    protected $table = 'recurrent_expenses';
    protected $fillable = ['name', 'description','color', 'cost', 'frequency','start_date','user_id'];
    public  $timestamps = true;

}
