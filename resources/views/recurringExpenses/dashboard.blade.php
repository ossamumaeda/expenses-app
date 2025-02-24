<div class="flex lg:flex-row flex-col">
    <div class="lg:w-2/5 w-3/4 h-auto self-center ">
        <div id="expenseChart" data-labels='@json($chartLabels)'
            data-data='@json($chartData)' data-color='@json($chartColor)'></div>
    </div>
    <div class="lg:w-3/5 w-full self-start ">

        <div class="w-full overflow-hidden rounded-lg">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-lg">
                @foreach ($recurrentExpenses as $expense)
                    <x-card :title="$expense->name" :color="$expense->color">
                        <x-slot:header>
                            <div class="text-gray-500 font-bold text-xl">{{ $expense->percentage }}%</div>
                        </x-slot:header>
                        <div class="flex flex-row justify-between">
                            <div class="font-bold text-black text-xl">R$ {{ $expense->cost }}</div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </div>
</div>