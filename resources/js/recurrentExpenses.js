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
  
    $("#save-recurrent").click(function() {
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

    $("#menu-toggle").click(function() {
        $("#sidebar").addClass("active");
        $("#overlay").removeClass("hidden");
    });

    $("#close-menu, #overlay").click(function() {
        $("#sidebar").removeClass("active");
        $("#overlay").addClass("hidden");
    });


  });
