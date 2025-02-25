<div class="w-full items-center justify-center hidden p-4" id="new-recurrent-form">
    <form action="{{ route('payment-method.store') }}" method="POST" class="w-full">
        @csrf
        <div class="w-full flex flex-col sm:flex-row gap-x-5 mb-4">
            <div class="sm:w-[10%] w-full">
                <label for="color" class="mb-3 block text-base font-medium text-[#07074D]">Color
                    picker</label>
                <input type="color"
                    class="p-1 h-10 w-14 block cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none "
                    name="color" id="color" value="#2563eb" title="Choose your color"
                    style="height: 57.2px;">
            </div>
            <div class="sm:w-[95%] w-full mb-2">
                <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                    Name
                </label>
                <input type="text" name="name" id="name" placeholder="Describe the expense"
                    min="0"
                    class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
        </div>
        <div class="w-full flex flex-col sm:flex-row gap-x-5">
            <div class="w-full mb-2">
                <label for="description" class="mb-3 block text-base font-medium text-[#07074D]">
                    Description
                </label>
                <input type="text" name="description" id="description" placeholder="Describe the expense"
                    min="0"
                    class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
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