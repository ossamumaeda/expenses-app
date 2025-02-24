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
            @include('paymentMethods.table',['paymentMethods' => $paymentMethods])
        </div>

    </div>
</div>
</x-layout.app>