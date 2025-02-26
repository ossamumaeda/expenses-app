<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recurrent_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the expense type
            $table->string('color');  // Name of the expense type
            $table->string('frequency');  // Name of the expense type
            $table->dateTime('start_date')->useCurrent();
            $table->float('cost',precision:3);  // Amount of the expense
            $table->text('description')->nullable();  // Description of the expense type
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recurrent_expenses');
    }
};
