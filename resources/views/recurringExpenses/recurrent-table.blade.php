<div class="w-full rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
            <tr>
                <th class="w-70 p-3 text-xs font-semibold tracking-wide text-left">Name</th>
                <th class="w-70 p-3 text-xs font-semibold tracking-wide text-left">Description</th>
                <th class="w-20 p-3 text-xs font-semibold tracking-wide text-left">Cost</th>
                <th class="w-20 p-3 text-xs font-semibold tracking-wide text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($recurrentExpenses as $expense)
                <tr class="odd:bg-white" data-id="{{ $expense->id }}">
                    <!-- Editable Name Field -->
                    <td class="p-3 text-base text-gray-900">
                        <span class="view-mode text-xs">{{ $expense->name }}</span>
                        <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                            value="{{ $expense->name }}">
                    </td>
                    <td class="p-3 text-sm text-gray-700">
                        <span class="view-mode text-xs">{{ $expense->description }}</span>
                        <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                            value="{{ $expense->description }}">
                    </td>
                    <!-- Editable Cost Field -->
                    <td class="p-3 text-sm text-gray-700">
                        <span class="view-mode text-xs">{{ $expense->cost }}</span>
                        <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                            value="{{ $expense->cost }}">
                    </td>

                    <!-- Edit / Save Button -->
                    <td class="flex items-center px-3 py-4 gap-2 ">
                        <button class="edit-btn font-medium text-blue-600 hover:underline">Edit</button>
                        <button
                            class="save-btn font-medium text-green-600 hover:underline hidden" id="save-recurrent">Save</button>
                        <button
                            class="cancel-btn font-medium text-red-500 hover:underline hidden">Cancel</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>