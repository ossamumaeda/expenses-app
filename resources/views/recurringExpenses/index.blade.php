@section('scripts')
    @vite(['resources/js/recurrentExpenses.js'])
@endsection
<x-layout.app>

    <div id="layout" class="sm:p-10 p-2 space-y-10 ">
        <div class="w-fulll flex flex-col rounded-lg shadow-lg sm:p-4 p-2 gap-y-5" id="parent">
            @include('recurringExpenses.dashboard-header',[
                'recurrentExpensesSum' => $recurrentExpensesSum
            ])

            @include('recurringExpenses.dashboard',[
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
                'chartColor' => $chartColor,
                'recurrentExpenses' => $recurrentExpenses
            ])
        </div>

        @include('recurringExpenses.recurrent-create-form')

        <div class="w-full" id="table-recurrent-expenses">
            @include('recurringExpenses.table-buttons')
            @include('recurringExpenses.recurrent-table',[
                'recurrentExpenses' => $recurrentExpenses
            ])
        </div>


    </div>

    @include('recurringExpenses.modal-csv')
</x-layout.app>
