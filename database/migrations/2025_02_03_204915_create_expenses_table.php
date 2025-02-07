<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name');  // Name of the expense
            $table->float('cost',precision:3);  // Amount of the expense
            $table->boolean('installments')->default(false);
            $table->dateTime('due_date')->useCurrent();
            $table->foreignId('expense_type_id')->constrained()->onDelete('cascade');  // Foreign key to types_of_expenses
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');  // Foreign key to types_of_expenses
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
