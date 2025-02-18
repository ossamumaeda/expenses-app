<x-layout.app>
    <div id="layout" class="sm:p-10 p-4 space-y-10 ">
        <div class="w-fulll flex flex-col rounded-lg shadow-lg sm:p-4 p-2 gap-y-5" id="parent">
            <div class="w-full flex flex-row justify-between  p-1">
                @include('dashboard.dashboard-graph', [
                    'expensesTotalCost' => $expensesTotalCost,
                    'todayMonth' => $todayMonth,
                ])
            </div>
            <div class="flex lg:flex-row flex-col">
                @include('dashboard.dashboard-cards', ['expensesByType' => $expensesByType])
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

    <script>
        function updateSelectColor(select) {
            let selectedOption = select.options[select.selectedIndex];
            select.style.backgroundColor = selectedOption.style.backgroundColor;
        }
        const myFunction = () => {
            const trs = document.querySelectorAll('#table-expenses-dashboard tr:not(.header)')
            const filter = document.querySelector('#myInput').value
            const regex = new RegExp(filter, 'i')
            const isFoundInTds = td => regex.test(td.innerHTML)
            const isFound = childrenArr => childrenArr.some(isFoundInTds)
            const setTrStyleDisplay = ({
                style,
                children
            }) => {
                style.display = isFound([
                    ...children // <-- All columns
                ]) ? '' : 'none'
            }

            trs.forEach(setTrStyleDisplay)
        }
    </script>
</x-layout.app>
