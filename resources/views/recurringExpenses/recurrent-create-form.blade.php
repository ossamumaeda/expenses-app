<div class="w-full items-center justify-center hidden" id="new-recurrent-form">

    <form id="recurrent-form" class="w-full">
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
                    class="p-1 h-10 w-14 block cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none "
                    name="color" id="color" value="#2563eb" title="Choose your color"
                    style="height: 57.2px;">
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