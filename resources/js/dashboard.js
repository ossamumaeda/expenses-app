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
    console.log("CLICK")
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
                    <tr class="odd:bg-white" data-id="{{ $expense->id }}">
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

});

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