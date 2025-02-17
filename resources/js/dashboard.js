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

});

