import './bootstrap';
import '../css/app.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
    //Menu
    $("#menu-toggle").click(function() {
        $("#sidebar").addClass("active");
        $("#overlay").removeClass("hidden");
    });

    $("#close-menu, #overlay").click(function() {
        $("#sidebar").removeClass("active");
        $("#overlay").addClass("hidden");
    });

    $("#logout-form").click(function(e){
        e.preventDefault()
        const token = localStorage.getItem('auth_token');
        $.ajax({
            url: '/api/destroy-token', // API route
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