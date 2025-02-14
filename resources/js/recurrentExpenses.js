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
  
    $(".save-btn").click(function() {
        var row = $(this).closest("tr");
        var expenseId = row.data("id");
  
        // Get updated values
        var updatedData = {
            id: expenseId,
            name: row.find("input[type='text']").eq(0).val(),
            description: row.find("input[type='text']").eq(1).val(),
            cost: row.find("input[type='text']").eq(2).val(),
        };
  
        // Send AJAX request to update the database (if needed)
        $.ajax({
            url: "/api/recurrent-expenses-update",  // Adjust your route
            type: "POST",
            data: updatedData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, // Laravel CSRF token
            success: function(response) {
                // Update UI with new values
                row.find(".view-mode").eq(0).text(updatedData.name);
                row.find(".view-mode").eq(1).text(updatedData.description);
                row.find(".view-mode").eq(2).text(updatedData.cost);
  
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

    $(".cancel-btn").click(function() {
        var row = $(this).closest("tr");
        row.find(".view-mode").removeClass("hidden");
        row.find(".edit-mode").addClass("hidden");

        // Show "Edit" button, hide "Save" button
        row.find(".edit-btn").removeClass("hidden");
        row.find(".save-btn").addClass("hidden");
        row.find(".cancel-btn").addClass("hidden");
    });

    $('#csv-upload-form').submit(function (event) {
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
                <table class="w-full">
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
                $('#response').append(table);
            },
            error: function (xhr, status, error) {
                $('#response').html('Error: ' + error);
            }
        });
    });

    $("#menu-toggle").click(function() {
        $("#sidebar").addClass("active");
        $("#overlay").removeClass("hidden");
    });

    $("#close-menu, #overlay").click(function() {
        $("#sidebar").removeClass("active");
        $("#overlay").addClass("hidden");
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