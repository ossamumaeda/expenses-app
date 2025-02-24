import './bootstrap';
import '../css/app.css';

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
});