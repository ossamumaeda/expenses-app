<x-layout.app>
    <div id="layout" class="sm:p-10 p-4 space-y-10 ">
        <div class="w-fulll flex flex-col rounded-lg shadow-lg sm:p-4 p-2 gap-y-5" id="parent">
            <div class="w-full flex flex-row justify-between  p-1">
                <div class="w-auto">
                    <h2 class="text-2xl sm:text-3xl font-medium text-gray-800">February</h1>
                        <p class="mt-2 text-xs text-gray-500">Grouped by categories</p>
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
                            <h3 class="text-lg sm:text-2xl font-medium text-gray-800">R${{ $expensesTotalCost }}</h3>
                            <p class="mt-1 text-xs text-gray-500">Total expended</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex lg:flex-row flex-col">
                <div class="lg:w-2/5 w-full h-auto self-center ">
                    <div id="expenseChart" data-labels='@json($chartLabels)'
                        data-data='@json($chartData)' data-color='@json($chartColor)'></div>
                </div>
                <div class="lg:w-3/5 w-full self-start ">
                    {{-- <div class="w-full rounded-lg shadow overflow-hidden hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="w-70 p-3 text-sm font-semibold tracking-wide text-left">Name</th>
                                    <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Cost</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($expensesByType as $expense)
                                    <tr class="odd:bg-white even:bg-slate-200">
                                        <td class="p-3 text-sm text-gray-700">{{ $expense->name }}</td>
                                        <td class="p-3 text-sm text-gray-700">{{ $expense->cost }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div> --}}
                    <div class="w-full overflow-hidden rounded-lg">
                        <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-lg">
                            @foreach ($expensesByType as $expense)
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
                {{-- <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                    @foreach ($expensesByType as $expense)
                        <div class="p-4 space-y-4 bg-white rounded-lg shadow">
                            <div class="flex items-center space-x-4 text-sm">
                                <div>
                                    <span
                                        class="p-1.5 text-xs font-medium uppercase tracking-wider
                                        text-yellow-600 bg-yellow-100 rounded-lg bg-opacity-50">
                                        {{ $expense->expense_type->name }}
                                    </span>
                                </div>
                                <div class="text-gray-500">{{ $expense->due_date }}</div>
                                <div class="text-gray-500">{{ $expense->installments }}</div>
                            </div>
                            <div class="text-sm text-gray-700">{{ $expense->name }}</div>
                            <div class="text-sm font-medium text-black">{{ $expense->cost }}</div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </div>

        <div class="" id="table-expenses">
            <div class="w-full flex items-center justify-center">
                <div class="mx-auto w-full">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf
                        <div class="mb-5 flex flex-col sm:flex-row gap-x-5">
                            <div class="sm:w-3/4 w-full ">
                                <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Name
                                </label>
                                <input type="text" name="name" id="name" placeholder="Expense name"
                                    min="0"
                                    class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            </div>
                            <div class="sm:w-1/4 w-full">
                                <label class="mb-3 block text-base font-medium text-[#07074D]"
                                    for="cost">Cost</label>
                                <div class="flex w-full">
                                    <div class="rounded-l flex text-white items-center px-3 bg-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-current"
                                            viewBox="0 0 288 512">
                                            <path
                                                d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z" />
                                        </svg>
                                    </div>
                                    <input min="0"
                                        class="w-full appearance-none rounded-r-md border border-[#e0e0e0] bg-white py-3 px-1 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                        type="number" name="cost" id="cost" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 w-full">
                            <label for="description" class="mb-3 block text-base font-medium text-[#07074D]">
                                Description
                            </label>
                            <input type="text" name="description" id="description" placeholder="Description"
                                min="0"
                                class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div class="flex sm:flex-row flex-col gap-x-5">
                            <div class="mb-5 sm:w-1/2 w-full">
                                <label for="expense_type_id"
                                    class="mb-3 block text-base font-medium text-[#07074D]">Expense
                                    type</label>
                                <select
                                    class="w-full py-3 px-6 edit-mode h-max p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0"
                                    id="expense_type_id" name="expense_type_id"
                                    style="background-color: {{ $expenseTypes[0]->color }};"
                                    onchange="updateSelectColor(this)">
                                    @foreach ($expenseTypes as $types)
                                        <option class="text-gray-700"  
                                        style="background-color: {{ $types->color }};font-weight: bold;" value={{ $types->id }}>{{ $types->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5 sm:w-1/2 w-full">
                                <label for="payment_method_id"
                                    class="mb-3 block text-base font-medium text-[#07074D]">Payment
                                    method</label>
                                <select
                                    class="w-full py-3 px-6 edit-mode h-max p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0"
                                    id="payment_method_id" name="payment_method_id"
                                    style="background-color: {{ $paymentMethods[0]->color }};"
                                    onchange="updateSelectColor(this)">
                                    @foreach ($paymentMethods as $types)
                                        <option class="text-gray-700" 
                                            style="background-color: {{ $types->color }};font-weight: bold;" value={{ $types->id }}>{{ $types->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>

                        <div class="-mx-3 flex flex-wrap">
                            <div class="w-full px-3 sm:w-1/2">
                                <div class="mb-5">
                                    <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Date
                                    </label>
                                    <input type="date" name="date" id="date"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                            <div class="w-full px-3 sm:w-1/2">
                                <div class="mb-5">
                                    <label for="time" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Time
                                    </label>
                                    <input type="time" name="time" id="time"
                                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <button
                                class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
                                type="submit">
                                Create
                            </button>

                            <button
                                class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
                                data-bs-toggle="modal" data-bs-target="#expenseModal" type="button" id="csv">
                                Import csv
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="w-full" id="cards-expenses">
            <div class="w-full rounded-lg shadow overflow-hidden hidden md:block ">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="w-40 p-3 text-sm font-semibold tracking-wide text-left">Date</th>
                            <th class="w-70 p-3 text-sm font-semibold tracking-wide text-left">Name</th>
                            <th class="w-60 p-3 text-sm font-semibold tracking-wide text-left">Category</th>
                            <th class="w-60 p-3 text-sm font-semibold tracking-wide text-left">Payment</th>
                            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Installments</th>
                            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Cost</th>
                            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($allExpenses as $expense)
                            <tr class="odd:bg-white even:bg-slate-200" data-id="{{ $expense->id }}">
                                <td class="p-3 text-sm text-gray-700">{{ $expense->due_date }}</td>

                                <!-- Editable Name Field -->
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode"
                                        id="view-name-{{ $expense->id }}">{{ $expense->name }}</span>
                                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                                        value="{{ $expense->name }}" id="name-{{ $expense->id }}">
                                </td>

                                <!-- Editable Category Field -->
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode">
                                        <span
                                            class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 break-words w-full inline-block text-center"
                                            style="background-color: {{ $expense->expenseType->color }}"
                                            id="view-type-{{ $expense->id }}">
                                            {{ $expense->expenseType->name }}
                                        </span>
                                    </span>
                                    <select
                                        class="edit-mode hidden p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0 shadow-md"
                                        style="background-color: {{ $expense->expenseType->color }};"
                                        id="expenseType-{{ $expense->id }}" onchange="updateSelectColor(this)">
                                        @foreach ($expenseTypes as $type)
                                            <option value="{{ $type->id }}" class="text-gray-700"
                                                style="background-color: {{ $type->color }};font-weight: bold;"
                                                {{ $expense->expenseType->id == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Editable Payment Field -->
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode block w-full">
                                        <span
                                            class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 break-words w-full inline-block text-center"
                                            style="background-color: {{ $expense->paymentMethod->color }}"
                                            id="view-payment-{{ $expense->id }}">
                                            {{ $expense->paymentMethod->name }}
                                        </span>
                                    </span>

                                    <select
                                        class="edit-mode hidden p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0 shadow-md"
                                        style="background-color: {{ $expense->paymentMethod->color }};"
                                        id="paymentMethod-{{ $expense->id }}" onchange="updateSelectColor(this)">
                                        @foreach ($paymentMethods as $method)
                                            <option value="{{ $method->id }}" class="text-gray-700"
                                                style="background-color: {{ $method->color }};font-weight: bold;"
                                                {{ $expense->paymentMethod->id == $method->id ? 'selected' : '' }}>
                                                {{ $method->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- Editable Installments Field -->
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode"
                                        id="view-installment-{{ $expense->id }}">{{ $expense->installments }}</span>
                                    <input type="number" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                                        value="{{ $expense->installments }}" id="stallment-{{ $expense->id }}">
                                </td>

                                <!-- Editable Cost Field -->
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode"
                                        id="view-cost-{{ $expense->id }}">{{ $expense->cost }}</span>
                                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                                        value="{{ $expense->cost }}" id="cost-{{ $expense->id }}">
                                </td>

                                <!-- Edit / Save Button -->
                                <td class="flex items-center px-3 py-4 gap-2">
                                    <button class="edit-btn font-medium text-blue-600 hover:underline">Edit</button>
                                    <button
                                        class="save-btn font-medium text-green-600 hover:underline hidden save_expense">Save</button>
                                    <button
                                        class="cancel-btn font-medium text-red-500 hover:underline hidden">Cancel</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
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
        </div>

    </div>

    <div class="modal mt-0 p-0" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-xl sm:text-2xl font-medium text-gray-800" id="expenseModalLabel">
                        Import recurrent expenses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="csv-upload-form" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-row justify-between">
                            <div>
                                <input type="file" name="csv_file" id="csv_file" accept=".csv"
                                    class="hidden" />
                                <label for="csv_file"
                                    class="cursor-pointer hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 mb-1 text-center text-base font-semibold text-white outline-none">
                                    Choose file
                                </label>
                            </div>
                            <div>
                                <button
                                    class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
                                    type="button" id="upload_csv">
                                    Upload csv
                                </button>
                            </div>
                        </div>

                    </form>
                    <div class="w-full rounded-lg shadow overflow-hidden" id="response"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateSelectColor(select) {
            let selectedOption = select.options[select.selectedIndex];
            select.style.backgroundColor = selectedOption.style.backgroundColor;
        }
    </script>
</x-layout.app>
