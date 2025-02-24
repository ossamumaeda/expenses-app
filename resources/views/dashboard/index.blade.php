<x-layout.app>
    <div id="layout" class="sm:p-10 p-4 space-y-10 ">
        <div class="w-fulll flex flex-col rounded-lg shadow-lg sm:p-4 p-2 gap-y-5" id="parent">
            <div class="w-full flex flex-row justify-between  p-1">
                @include('dashboard.dashboard-header', [
                    'expensesTotalCost' => $expensesTotalCost,
                    'todayMonth' => $todayMonth,
                ])
            </div>
            <div class="flex lg:flex-row flex-col">
                @include('dashboard.dashboard', ['expensesByType' => $expensesByType])
            </div>
        </div>

        @include('dashboard.expenses-create-form', [
            'expenseTypes' => $expenseTypes,
            'paymentMethods' => $paymentMethods,
        ])

        <div class="w-full" id="">
            @include('dashboard.expenses-filter', ['countExpenses' => $countExpenses])

            @include('dashboard.expenses-table', ['allExpenses ' => $allExpenses])

            @include('dashboard.expenses-cards', ['allExpenses' => $allExpenses])
        </div>

    </div>

    @include('dashboard.modal-csv')

</x-layout.app>
