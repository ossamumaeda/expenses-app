<div class="w-full flex flex-row justify-between  p-1">
    <div class="w-auto">
        <h2 class="text-2xl sm:text-3xl font-medium text-gray-800">Recurrent</h1>
            <p class="mt-2 text-xs text-gray-500">Monthly base expenses</p>
    </div>
    <div class="flex items-center bg-white rounded-lg ">
        <div class="flex items-center -mx-2">

            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                fill="none" stroke="red" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-trending-down hidden sm:block">
                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6" />
                <polyline points="17 18 23 18 23 12" />
            </svg>

            <div class="mx-4">
                <h3 class="text-lg sm:text-2xl font-medium text-gray-800">R${{ $recurrentExpensesSum }}</h3>
                <p class="mt-1 text-xs text-gray-500">Total calculated</p>
            </div>
        </div>
    </div>

</div>