<div class="w-full hidden border border-gray-200 rounded-sm md:block">
    <table class="w-full" id="table-expenses-dashboard">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
            <tr>
                <th class="w-40 p-3 text-sm font-semibold tracking-wide text-left">Date</th>
                <th class="w-60 p-3 text-sm font-semibold tracking-wide text-left">Name</th>
                <th class="w-60 p-3 text-sm font-semibold tracking-wide text-left">Category</th>
                <th class="w-60 p-3 text-sm font-semibold tracking-wide text-left">Payment</th>
                <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Installments</th>
                <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Cost</th>
                <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100" id="expense-body">
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
                    <td class="p-3 text-sm text-gray-700" id="id-expense">
                        <span class="view-mode" id="expense-type">
                            <span
                                class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 break-words w-full inline-block text-center"
                                style="background-color: {{ $expense->expenseType->color }}"
                                id="view-type-{{ $expense->id }}">
                                {{ $expense->expenseType->name }}
                            </span>
                        </span>
                        <select
                            class="w-full trigger-color edit-mode hidden p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0 shadow-md"
                            style="background-color: {{ $expense->expenseType->color }};"
                            id="expenseType-{{ $expense->id }}" >
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
                    <td class="p-3 text-sm text-gray-700" id="id-payment">
                        <span class="view-mode block w-full" id="payment-type">
                            <span
                                class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 break-words w-full inline-block text-center"
                                style="background-color: {{ $expense->paymentMethod->color }}"
                                id="view-payment-{{ $expense->id }}">
                                {{ $expense->paymentMethod->name }}
                            </span>
                        </span>

                        <select
                            class="w-full trigger-color edit-mode hidden p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0 shadow-md"
                            style="background-color: {{ $expense->paymentMethod->color }};"
                            id="paymentMethod-{{ $expense->id }}" >
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