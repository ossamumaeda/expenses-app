<div id="table-filter">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 ">Expenses</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full ">{{ $countExpenses }}
                    registers</span>
            </div>
            <p class="mt-1 text-sm text-gray-500 ">Total expenses registered in {{ $todayMonth }}</p>
        </div>

        <div class="flex items-center mt-4 gap-x-3" id="">
            <button
                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors 
                duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto 
                hover:bg-gray-100 "
                data-bs-toggle="modal" data-bs-target="#expenseModal" type="button" id="csv">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_3098_154395)">
                        <path
                            d="M13.3333 13.3332L9.99997 9.9999M9.99997 9.9999L6.66663 13.3332M9.99997 9.9999V17.4999M16.9916 15.3249C17.8044 14.8818 18.4465 14.1806 18.8165 13.3321C19.1866 12.4835 19.2635 11.5359 19.0351 10.6388C18.8068 9.7417 18.2862 8.94616 17.5555 8.37778C16.8248 7.80939 15.9257 7.50052 15 7.4999H13.95C13.6977 6.52427 13.2276 5.61852 12.5749 4.85073C11.9222 4.08295 11.104 3.47311 10.1817 3.06708C9.25943 2.66104 8.25709 2.46937 7.25006 2.50647C6.24304 2.54358 5.25752 2.80849 4.36761 3.28129C3.47771 3.7541 2.70656 4.42249 2.11215 5.23622C1.51774 6.04996 1.11554 6.98785 0.935783 7.9794C0.756025 8.97095 0.803388 9.99035 1.07431 10.961C1.34523 11.9316 1.83267 12.8281 2.49997 13.5832"
                            stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_3098_154395">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg>

                <span>Import</span>
            </button>

            <button
                class="flex items-center justify-center w-1/2 px-1 sm:px-5 !important py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600"
                id="new-expense-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span>New expense</span>
            </button>
            <button
                class="hidden items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600"
                id="new-expense-cancel-btn">
                <span>Cancel</span>
            </button>
        </div>
    </div>
    <div class="mt-4 mb-4 md:flex md:items-center md:justify-between">
        <div class="justify-between flex flex-row gap-2">
            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse ">
                <button
                    class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm ">
                    View all
                </button>
            </div>
            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse ">
                <select
                    class="focus:outline-none px-5 py-2 text-xs font-medium text-gray-600   sm:text-sm "
                    id="expense-filter" name="expense_type_id" style="background-color:#FFF">
                    <option class="text-gray-700" style="background-color: #FFF;font-weight: bold;"
                        value=-1>Select All</option>
                    @foreach ($expenseTypes as $types)
                        <option class="text-gray-700" style="background-color: {{ $types->color }};font-weight: bold;"
                            value={{ $types->id }}>{{ $types->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse ">
                <select
                    class="focus:outline-none px-5 py-2 text-xs font-medium text-gray-600   sm:text-sm "
                    id="payment-filter" name="payment_method_id" style="background-color:#FFF">
                    <option class="text-gray-700" style="background-color: #FFF;font-weight: bold;"
                        value=-1>Select All</option>
                    @foreach ($paymentMethods as $types)
                        <option class="text-gray-700" style="background-color: {{ $types->color }};font-weight: bold;"
                            value={{ $types->id }}>{{ $types->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="relative flex items-center mt-4 md:mt-0">
            <input type="text" placeholder="Search" id="myInput"
                class="block w-full py-2 pr-2 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-5 rtl:pr-11 rtl:pl-5
          focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
        </div>
        
    </div>
</div>
