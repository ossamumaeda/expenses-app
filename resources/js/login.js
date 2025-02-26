$(document).ready(function() {
    $("#login-form").submit(function(event){
        // Capture the form data before submitting the form
        const email = $("#email").val();
        const password = $("#password").val();
    
        // Send an AJAX request to get the token before the form is submitted
        $.ajax({
            url: '/api/create-token', // Your login route
            method: 'POST',
            data: {
                email: email,
                password: password,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token from Blade
            },
            success: function(response) {
                // Store the token in localStorage
                localStorage.setItem('auth_token', response.token);
            },
            error: function(response) {
                console.log("Login failed", response);
                alert('Login failed, please try again.');
            }
        });
    
        // No need to prevent the form submission; it will proceed to Laravel's login route
    });

    $("#register-form").submit(function(event){
        event.preventDefault(); 
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());

        $.ajax({
            url: '/register', // API route
            type: 'POST',
            data: JSON.stringify(data),
            headers: { "Content-Type": "application/json" },
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting contentType
            success: function (response) {
                localStorage.setItem("auth_token", response.token); // Store token
                window.location.href = "/"; // Redirect user if needed
            }
        });
    })

    $(".logout-btn").click(function(e){
        e.preventDefault()
        $("#logout-btn").trigger("submit"); 
        console.log("Logou")
        const token = localStorage.getItem('auth_token');
        $.ajax({
            url: '/destroy-token', // API route
            type: 'POST',
            headers: { "Content-Type": "application/json","Authorization": `Bearer ${token}` },
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting contentType
            success: function (response) {
                window.location.href = "/login"; // Redirect user if needed
            }
        });
    })

    
});


