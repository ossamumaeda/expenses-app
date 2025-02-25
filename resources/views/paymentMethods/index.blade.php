@section('scripts')
    @vite(['resources/js/paymentMethods.js'])
@endsection
<x-layout.app>
<div id="layout" class="sm:p-10 p-2 space-y-10 ">
    <div class="w-fulll flex flex-col rounded-lg shadow-lg sm:p-4 p-2 gap-y-5" id="parent">
        <div class="w-full flex flex-row justify-between  p-1">
            <div class="w-auto">
                <h2 class="text-2xl sm:text-3xl font-medium text-gray-800">Expense types</h1>
                    <p class="mt-2 text-xs text-gray-500">Categorize expenses types</p>
            </div>
        </div>

        <div class="w-full rounded-lg shadow overflow-hidden">
            @include('paymentMethods.payment-create-form')
            
            <div class="sm:flex sm:items-center sm:justify-between mb-4 justify-self-end">
                <div class="flex items-center mt-4 px-2" id="">            
                    <button
                        class="flex items-center justify-center w-1/2 px-1 sm:px-5 !important py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600"
                        id="new-recurrent-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>New expense</span>
                    </button>
                    <button
                        class="hidden items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600"
                        id="new-recurrent-cancel-btn">
                        <span>Cancel</span>
                    </button>
                </div>
            </div>
            @include('paymentMethods.table',['paymentMethods' => $paymentMethods])
        </div>

    </div>
</div>
</x-layout.app>