
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