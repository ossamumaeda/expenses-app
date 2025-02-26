$(document).ready(function() {
    $("#edit-btn").click(function() {
        var row = $(this).closest("tr");
  
        // Hide "view-mode" spans and show input fields
        row.find(".view-mode").addClass("hidden");
        row.find(".edit-mode").removeClass("hidden");
  
        // Show "Save" button, hide "Edit" button
        row.find("#edit-btn").addClass("hidden");
        row.find("#save-btn").removeClass("hidden");
        row.find("#cancel-btn").removeClass("hidden");
    });
  
    $("#save-btn").click(function() {
        const token = localStorage.getItem('auth_token');

        var row = $(this).closest("tr");
        var typeId = row.data("id");
  
        // Get updated values
        var updatedData = {
            id: typeId,
            name: row.find("input[type='text']").eq(0).val(),
            color: row.find("input[type='text']").eq(1).val(),
            user_id: 1
        }
        // Send AJAX request to update the database (if needed)
        $.ajax({
            url: "/api/types-update",  // Adjust your route
            type: "POST",
            data: updatedData,
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': `Bearer ${token}`
            }, // Laravel CSRF token
            success: function(response) {
                // Update UI with new values
                row.find(".view-mode").eq(0).text(updatedData.name);
                row.find(".view-mode").eq(1).text(updatedData.color);
  
                // Hide input fields and show updated spans
                row.find(".view-mode").removeClass("hidden");
                row.find(".edit-mode").addClass("hidden");
  
                // Show "Edit" button, hide "Save" button
                row.find("#edit-btn").removeClass("hidden");
                row.find("#save-btn").addClass("hidden");
                row.find("#cancel-btn").addClass("hidden");

            }
        });
    });

    $("#cancel-btn").click(function() {
        var row = $(this).closest("tr");
        row.find(".view-mode").removeClass("hidden");
        row.find(".edit-mode").addClass("hidden");

        // Show "Edit" button, hide "Save" button
        row.find("#edit-btn").removeClass("hidden");
        row.find("#save-btn").addClass("hidden");
        row.find("#cancel-btn").addClass("hidden");
    });

    // Create form
    $("#new-recurrent-btn").click(function() {
        $("#types-form").toggleClass("hidden flex");
        $("#new-recurrent-btn").toggleClass("hidden block");
        $("#new-recurrent-cancel-btn").toggleClass("hidden block");
    });

    $("#new-recurrent-cancel-btn").click(function(){
        $("#types-form").toggleClass("flex hidden");
        $("#new-recurrent-btn").toggleClass("hidden block");
        $("#new-recurrent-cancel-btn").toggleClass("block hidden");
    });

    $("#form-type").on('submit',function(){
        event.preventDefault(); // Prevent default form submission
        const token = localStorage.getItem('auth_token');
        let formData = $("#form-type").serialize();
        // Get updated values

        // Send AJAX request to update the database (if needed)
        $.ajax({
            url: "/api/types",  // Adjust your route
            type: "POST",
            data: formData,
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': `Bearer ${token}`
            }, // Laravel CSRF token
            success: function(response) {
                appendRow(response)
            }
        });
    });
});

function appendRow(row){
    $("#expense-type-table").append(`
       <tr class="odd:bg-white" data-id="${row.id}">
            <!-- Editable Name Field -->
            <td class="p-3 text-base text-gray-900">
                <span class="view-mode text-xs">${row.name}</span>
                <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                    value="${row.name}">
            </td>

            <td class="p-3 text-base text-gray-900">
                <span class="view-mode text-xs">${row.color}</span>
                <input type="text" class="edit-mode hidden w-full border px-2 py-1 text-sm"
                    value="${row.color}">
            </td>

            <!-- Edit / Save Button -->
            <td class="flex items-center px-3 py-4 gap-2 ">
                <button class="font-medium text-blue-600 hover:underline" id="edit-btn">Edit</button>
                <button
                    class="font-medium text-green-600 hover:underline hidden" id="save-btn">Save</button>
                <button
                    class="font-medium text-red-500 hover:underline hidden" id="cancel-btn">Cancel</button>
            </td>
        </tr>
    `);
}