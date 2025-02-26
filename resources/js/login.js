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
    
                console.log("Login successful, token stored!");
    
                // After storing the token, the form will be submitted automatically as usual
            },
            error: function(response) {
                console.log("Login failed", response);
                alert('Login failed, please try again.');
            }
        });
    
        // No need to prevent the form submission; it will proceed to Laravel's login route
    });

    $("#register-form").submit(function(event){
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
    
                console.log("Login successful, token stored!");
    
                // After storing the token, the form will be submitted automatically as usual
            },
            error: function(response) {
                console.log("Login failed", response);
                alert('Login failed, please try again.');
            }
        });
    
        // No need to prevent the form submission; it will proceed to Laravel's login route
    });
    
});
