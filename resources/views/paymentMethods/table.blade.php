<table class="w-full">
    <thead class="bg-gray-50 border-b-2 border-gray-200">
        <tr>
            <th class="w-70 p-3 text-xs font-semibold tracking-wide text-left">Name</th>
            <th class="w-70 p-3 text-xs font-semibold tracking-wide text-left">Color</th>
            <th class="w-20 p-3 text-xs font-semibold tracking-wide text-left">Action</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @foreach ($paymentMethods as $type)
            <tr class="odd:bg-white" data-id="{{ $type->id }}">
                <!-- Editable Name Field -->
                <td class="p-3 text-base text-gray-900">
                    <span class="view-mode text-xs">{{ $type->name }}</span>
                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                        value="{{ $type->name }}">
                </td>

                <td class="p-3 text-base text-gray-900">
                    <span class="view-mode text-xs">{{ $type->color }}</span>
                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                        value="{{ $type->color }}">
                </td>

                <!-- Edit / Save Button -->
                <td class="flex items-center px-3 py-4 gap-2 ">
                    <button class="font-medium text-blue-600 hover:underline" id="edit-btn">Edit</button>
                    <button
                        class="font-medium text-green-600 hover:underline hidden" id="save-btn">Save</button>
                    <button
                        class="font-medium text-red-500 hover:underline hidden" id="cancel-btn">Cancel</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>