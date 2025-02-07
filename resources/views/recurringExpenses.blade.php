<x-layout.app>
    <div id="layout" class="sm:p-10 p-4 space-y-10 ">
        <div class="w-fulll flex flex-col rounded-lg shadow-lg sm:p-4 p-2 gap-y-5" id="parent">
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

            <div class="flex lg:flex-row flex-col">
                <div class="lg:w-2/5 w-full h-auto self-center ">
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
        </div>

        <div class="w-full flex items-center justify-center">

            <form action="{{ route('recurrent-expenses.store') }}" method="POST" class="w-full">
                @csrf
                <div class="w-full flex flex-col sm:flex-row gap-x-5">
                    <div class="sm:w-3/4 w-full mb-2">
                        <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                            Name
                        </label>
                        <input type="text" name="name" id="name" placeholder="Describe the expense"
                            min="0"
                            class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                    <div class="sm:w-1/4 w-full">
                        <label class="mb-3 block text-base font-medium text-[#07074D]" for="cost">Cost</label>
                        <div class="flex w-full">
                            <div class="rounded-l flex text-white items-center px-3 bg-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-current" viewBox="0 0 288 512">
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
                <div class="w-full flex flex-col sm:flex-row gap-x-5">
                    <div class="sm:w-3/4 w-full mb-2">
                        <label for="description" class="mb-3 block text-base font-medium text-[#07074D]">
                            Description
                        </label>
                        <input type="text" name="description" id="description" placeholder="Describe the expense"
                            min="0"
                            class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>
                    <div class="sm:w-1/4 w-full">
                        <label for="color" class="mb-3 block text-base font-medium text-[#07074D]">Color
                            picker</label>
                        <input type="color"
                            class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700"
                            name="color" id="color" value="#2563eb" title="Choose your color" style="height: 57.2px;">
                    </div>
                </div>
                <div>
                    <button
                        class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
                        type="submit">
                        Create
                    </button>
                </div>
            </form>

        </div>

        <div class="w-full">
            <div class="w-full rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="w-70 p-3 text-sm font-semibold tracking-wide text-left">Name</th>
                            <th class="w-70 p-3 text-sm font-semibold tracking-wide text-left">Description</th>
                            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Cost</th>
                            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recurrentExpenses as $expense)
                            <tr class="odd:bg-white" data-id="{{ $expense->id }}">
                                <!-- Editable Name Field -->
                                <td class="p-3 text-base text-gray-900">
                                    <span class="view-mode">{{ $expense->name }}</span>
                                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm" value="{{ $expense->name }}">
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode">{{ $expense->description }}</span>
                                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm" value="{{ $expense->description }}">
                                </td>
                                <!-- Editable Cost Field -->
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="view-mode">{{ $expense->cost }}</span>
                                    <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm" value="{{ $expense->cost }}">
                                </td>
                
                                <!-- Edit / Save Button -->
                                <td class="flex items-center px-3 py-4 gap-2 ">
                                    <button class="edit-btn font-medium text-blue-600 hover:underline">Edit</button>
                                    <button class="save-btn font-medium text-green-600 hover:underline hidden">Save</button>
                                    <button class="cancel-btn font-medium text-red-500 hover:underline hidden">Cancel</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</x-layout.app>
