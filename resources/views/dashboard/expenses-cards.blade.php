<div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden" id="card-expenses">
    @foreach ($allExpenses as $expense)
        <x-card :title="$expense->expenseType->name" :color="$expense->expenseType->color">
            <x-slot:header>
                <div class="text-gray-500">{{ $expense->due_date }}</div>
                <div class="text-gray-500">{{ $expense->installments }}</div>
            </x-slot:header>
            <div class="flex flex-col">
                <div class="text-sm text-gray-700">{{ $expense->name }}</div>
                <div class="text-sm font-medium text-black">R$ {{ $expense->cost }}</div>
            </div>
        </x-card>
    @endforeach
</div>