document.addEventListener("DOMContentLoaded", function () {
  const labels = JSON.parse(document.getElementById("expenseChart").dataset.labels).map(function(x){ return x.toUpperCase(); });
  const data = JSON.parse(document.getElementById("expenseChart").dataset.data);
  const color = JSON.parse(document.getElementById("expenseChart").dataset.color);

  var options = {
    chart: {
        type: 'pie',
        height: 'auto', // Let it adjust based on the container
        width: '100%' // Ensures it takes full width
    },
    stroke: { show: false} ,
    series: data,
    labels: labels,
    plotOptions: {
        pie: {
            customScale: 1, // Try values between 0.8 - 1.2 for better scaling
        }
    },
    legend: {
        position: 'top', // Move legend to the top on small screens
        fontSize: '12px',
        itemMargin: {
            horizontal: 5,
            vertical: 5
        }
    },
    dataLabels:{
      enabled: true,
      style: {
        fontSize: '20px',
      }
    },
    colors: color,
    responsive: [
        {
            breakpoint: 500, // Adjust when the screen is smaller than 600px
            options: {
                chart: {
                    height: 250 // Reduce chart size for smaller screens
                },
                legend: {
                    position: 'top',
                    fontSize: '8px'
                },
                dataLabels:{
                  style: {
                    fontSize: '10px',
                  }
                },
            }
        }
    ]
  };

    var chart = new ApexCharts(document.querySelector("#expenseChart"), options);
    chart.render();

});


$(document).ready(function() {

    $(".edit-btn").click(function() {
        var row = $(this).closest("tr");

        // Hide "view-mode" spans and show input fields
        row.find(".view-mode").addClass("hidden");
        row.find(".edit-mode").removeClass("hidden");

        // Show "Save" button, hide "Edit" button
        row.find(".edit-btn").addClass("hidden");
        row.find(".save-btn").removeClass("hidden");
        row.find(".cancel-btn").removeClass("hidden");
    });

    $(".save_expense").click(function() {

        var row = $(this).closest("tr");
        var expenseId = row.data("id");

        // Get updated values
        var updatedData = {
            id: expenseId,
            name: row.find("#name-"+expenseId).val(),
            cost: row.find("#cost-"+expenseId).val(),
            installments: row.find("#installment-"+expenseId).val(),
            expense_type_id:row.find("#expenseType-"+expenseId).val(),
            payment_method_id:row.find("#paymentMethod-"+expenseId).val()
        };

        let expenseType = row.find("#expenseType-" + expenseId)[0]; // Get the DOM element
        let selectedOption = expenseType.options[expenseType.selectedIndex]; // Get the selected <option>
        let selectedColor = selectedOption.style.backgroundColor; // Get its background color
        let selectedLabel = selectedOption.text.trim(); // Get selected option text
        
        let paymentMethod = row.find("#paymentMethod-" + expenseId)[0]; // Get the DOM element
        let paymentOption = paymentMethod.options[paymentMethod.selectedIndex]; // Get the selected <option>
        let paymentColor = paymentOption.style.backgroundColor; // Get its background color
        let paymentLabel = paymentOption.text.trim(); // Get selected option text

        // Send AJAX request to update the database (if needed)
        $.ajax({
            url: "/api/expenses-update",  // Adjust your route
            type: "POST",
            data: updatedData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, // Laravel CSRF token
            success: function(response) {
                // Update UI with new values
                row.find("#view-name-"+expenseId).text(updatedData.name);
                row.find("#view-installment-"+expenseId).text(updatedData.installments);
                row.find("#view-cost-"+expenseId).text(updatedData.cost);

                row.find("#view-type-" + expenseId).text(selectedLabel);
                row.find("#view-type-" + expenseId).css("background-color",selectedColor);

                row.find("#view-payment-" + expenseId).text(paymentLabel);
                row.find("#view-payment-" + expenseId).css("background-color",paymentColor);

                // Hide input fields and show updated spans
                row.find(".view-mode").removeClass("hidden");
                row.find(".edit-mode").addClass("hidden");

                // Show "Edit" button, hide "Save" button
                row.find(".edit-btn").removeClass("hidden");
                row.find(".save-btn").addClass("hidden");
                row.find(".cancel-btn").addClass("hidden");

            }
        });
    });

    $("#new-expense-btn").click(function() {
        $("#new-expense-form").toggleClass("hidden block");
        $("#new-expense-btn").toggleClass("hidden block");
        $("#new-expense-cancel-btn").toggleClass("hidden block");
    });

    $("#new-expense-cancel-btn").click(function(){
        $("#new-expense-form").toggleClass("block hidden");
        $("#new-expense-btn").toggleClass("hidden block");
        $("#new-expense-cancel-btn").toggleClass("block hidden");
    });

    $('#csv_file').on('change', function () {
        if ($(this).val()) {
            $('#csv-upload-form').submit(); // Auto-submit the form
        }
    });

    $('#csv-upload-form').submit(function (event) {
        console.log("Changes");
        event.preventDefault(); // Prevent form submission

        var formData = new FormData(this); // Create FormData object with the form data

        $.ajax({
            url: '/api/upload-csv', // API route
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting contentType
            success: function (response) {
                let table = `
                <table class="w-full" id="table-expenses">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="w-70 p-3 text-sm font-semibold tracking-wide text-left">Name</th>
                        <th class="w-70 p-3 text-sm font-semibold tracking-wide text-left">Description</th>
                        <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Cost</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                `;
                response.forEach(line => {
                    table = table.concat(`
                        <tr class="odd:bg-white" data-id="${row.id}">
                            <td class="p-3 text-base text-gray-900">
                                <span class="view-mode"> ${line['name']} </span>
                            </td>
                            <td class="p-3 text-base text-gray-900">
                                <span class="view-mode"> ${line['description']} </span>
                            </td>
                            <td class="p-3 text-base text-gray-900">
                                <span class="view-mode"> ${line['cost']} </span>
                            </td>
                        </tr>
                    `);
                });
                table =  table.concat(`
                    </tbody>
                </table>
                `);
                $('#response').empty();
                $('#response').append(table);
            },
            error: function (xhr, status, error) {
                $('#response').html('Error: ' + error);
            }
        });
    });

    $("#upload_csv").click(function(){
        let tableData = [];

        $('#table-expenses tbody tr').each(function () {
            let row = $(this).find('td'); // Get all <td> in the row
            let rowData = {
                name: row.eq(0).find('span').text().trim(),
                description: row.eq(1).find('span').text().trim(),
                cost: row.eq(2).find('span').text().trim(),
            };
            tableData.push(rowData);
        });
        
        if(!tableData.length){
        return;
        }

        $.ajax({
            url: '/api/expenses-create', // Change to your API route
            type: 'POST',
            data: JSON.stringify({ expenses: tableData }),
            contentType: 'application/json',
            success: function (response) {
            $("#expenseModal").modal("hide");
            $('#response').empty();
            },
            error: function (xhr) {
                alert('Failed to send data.');
                console.error(xhr);
            }
        });
    });

    // Filters
    $('#expense-filter').on('change',function() {
        filterCategory();
        let select = $('#expense-filter'); 
        changeElementBackgroundColor(select);
    });
    
    $('#expense_type_id').on('change',function() {
        filterCategory();
        let select = $('#expense_type_id'); 
        changeElementBackgroundColor(select);
    });

    $('#payment_method_id').on('change',function() {
        filterCategory();
        let select = $('#payment_method_id'); 
        changeElementBackgroundColor(select);
    });

    $('#payment-filter').on('change',function() {
        filterCategory();
        let select = $('#payment-filter'); 
        changeElementBackgroundColor(select);
    });
    
    $(".trigger-color").on("change",function(){
        let id = $(this).attr("id"); // Get the ID of the element that triggered the event
        let select = $('#'+id); 
        changeElementBackgroundColor(select);
    });

    $("#myInput").on("keyup", function() {
        myFunction(); // Call your function when the user types
    });
    
    $("#view-all-btn").click(function() {
        $('#payment-filter').val('-1').change()
        $('#expense-filter').val('-1').change()
    });

    $("#new-expense").on('submit',function(){
        event.preventDefault(); // Prevent default form submission
        const token = localStorage.getItem('auth_token');
        let formData = $(this).serialize();
        let expenseTypes = $("#new-expense").data("types");
        let paymentMethods = $("#new-expense").data("payment");
        // Send AJAX request to update the database (if needed)
        $.ajax({
            url: "/api/expenses",  // Adjust your route
            type: "POST",
            data: formData,
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': `Bearer ${token}`
            }, // Laravel CSRF token
            success: function(response) {
                appendRow(response,expenseTypes,paymentMethods)
            }
        });
    });
    

});

function appendRow(row,expenseTypes,paymentMethods){
    $("#expense-body").append(`
                <tr class="odd:bg-white even:bg-slate-200" data-id="${row.id}">
                    <td class="p-3 text-sm text-gray-700">${row.due_date}</td>

                    <!-- Editable Name Field -->
                    <td class="p-3 text-sm text-gray-700">
                        <span class="view-mode"
                            id="view-name-${row.id}">${row.name}</span>
                        <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                            value="${row.name}" id="name-${row.id}">
                    </td>

                    <!-- Editable Category Field -->
                    <td class="p-3 text-sm text-gray-700" id="id-expense">
                        <span class="view-mode" id="expense-type">
                            <span
                                class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 break-words w-full inline-block text-center"
                                style="background-color:${row.expense_type.color}"
                                id="view-type-${row.id}">
                                ${row.expense_type.name}
                            </span>
                        </span>
                        <select
                            class="trigger-color edit-mode hidden p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0 shadow-md"
                            style="background-color:${row.expense_type.color};"
                            id="expenseType-${row.id}" >`);
    let expenseTypeSelect = '';
    expenseTypes.forEach((type) =>{
        let selected = row.expense_type.id == type.id ? 'selected' : '';
        expenseTypeSelect = expenseTypeSelect + `
        <option value="${type.id}" class="text-gray-700"
            style="background-color: ${type.color};font-weight: bold;"
            ${selected}>
            ${type.name}
        </option>
        `
    })
    $("#expense-type-table").append(expenseTypeSelect);
    $("#expense-type-table").append(`
                        </select>
                    </td>

                    <!-- Editable Payment Field -->
                    <td class="p-3 text-sm text-gray-700" id="id-payment">
                        <span class="view-mode block w-full" id="payment-type">
                            <span
                                class="p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 break-words w-full inline-block text-center"
                                style="background-color:${row.payment_method.color}"
                                id="view-payment-${row.id}">
                                ${row.payment_method.name}
                            </span>
                        </span>

                        <select
                            class="trigger-color edit-mode hidden p-1.5 text-xs font-medium uppercase tracking-wider rounded-lg bg-opacity-50 focus:outline-none border-0 shadow-md"
                            style="background-color: ${row.payment_method.color};"
                            id="paymentMethod-${row.id}" >`);
    
    let paymentMethodsSelect = '';
    paymentMethods.forEach((payment) =>{
        let selected = row.payment_method.id == payment.id ? 'selected' : '';
        expenseTypeSelect = expenseTypeSelect + `
        <option value="${payment.id}" class="text-gray-700"
            style="background-color: ${payment.color};font-weight: bold;"
            ${selected}>
            ${payment.name}
        </option>
        `
    });
    $("#expense-type-table").append(paymentMethodsSelect);
    $("#expense-type-table").append(`
                </select>
                    </td>

                    <!-- Editable Installments Field -->
                    <td class="p-3 text-sm text-gray-700">
                        <span class="view-mode"
                            id="view-installment-${row.id}">${row.installments}</span>
                        <input type="number" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                            value="${row.installments}" id="stallment-${row.id}">
                    </td>

                    <!-- Editable Cost Field -->
                    <td class="p-3 text-sm text-gray-700">
                        <span class="view-mode"
                            id="view-cost-${row.id}">{{ $expense->cost }}</span>
                        <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                            value="{{ $expense->cost }}" id="cost-${row.id}">
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
    `);
}

function myFunction() {
    const trs = document.querySelectorAll('#table-expenses-dashboard tr:not(.header)')
    const filter = document.querySelector('#myInput').value
    const regex = new RegExp(filter, 'i')
    const isFoundInTds = (td) => {
        // Get text from the <span> inside the <td>
        const spanText = td.querySelector('span') ? td.querySelector('span').textContent.trim() : '';

        // Get selected value from the <select> inside the <td>
        const selectValue = td.querySelector('select') ? td.querySelector('select').value.trim() : '';

        // Check if the search term matches either span text or select value
        return regex.test(spanText) || regex.test(selectValue);
    };
    const isFound = childrenArr => childrenArr.some(isFoundInTds)
    const setTrStyleDisplay = ({
        style,
        children
    }) => {
        style.display = isFound([
            ...children // <-- All columns
        ]) ? '' : 'none'
    }

    trs.forEach(setTrStyleDisplay)
}

function changeElementBackgroundColor(select){
    let selectedOption = select.find(':selected'); // Get selected <option>
    // Get the background color of the selected option
    let bgColor = selectedOption.css('background-color');

    // Apply it to the select element
    select.css('background-color', bgColor);
}

function filterCategory(){ 
    let filterExpense = $('#expense-filter').find('option:selected').text();
    let filterPayment = $('#payment-filter').find('option:selected').text();

    const regexExpense = filterExpense == "Select All" ? false : new RegExp(filterExpense, 'i');
    const regexPayment = filterPayment == "Select All" ? false : new RegExp(filterPayment, 'i');
    
    const isFoundInTds = (childrenArr) => {
        let expense = true;
        let payment = true;
        childrenArr.forEach(td => {
            if(td.id == 'id-expense' && regexExpense){
                const expenseText = td.querySelector('span#expense-type') ? td.querySelector('span#expense-type').textContent.trim() : '';
                expense =  regexExpense.test(expenseText)
            }
            else if(td.id == 'id-payment' && regexPayment){
                const paymentText = td.querySelector('span#payment-type') ? td.querySelector('span#payment-type').textContent.trim() : '';
                payment =  regexPayment.test(paymentText)
            }
        });
        return (expense && payment);
    };
    // For each child, wich means -> Each column of the row, calls isFoundIn Tds 
    const setTrStyleDisplay = ({
        style,
        children
    }) => {
        style.display = isFoundInTds([
            ...children // <-- All columns
        ]) ? '' : 'none'
    }

    // Gett all the rows in the table
    const trs = document.querySelectorAll('#table-expenses-dashboard tr:not(.header)')
    // For each rows call the function
    trs.forEach(setTrStyleDisplay)
}

document.addEventListener("DOMContentLoaded", function () {
  const myModal = document.getElementById("expenseModal");
  const contentDiv = document.getElementById("response"); // Change this to your actual div ID
  const fileInput = document.getElementById("csv_file");

  if (myModal) {
      myModal.addEventListener("hidden.bs.modal", function () {
          document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
          contentDiv.innerHTML = ""; // Clears the content of the div
          fileInput.value = ""; 
      });
  }
});