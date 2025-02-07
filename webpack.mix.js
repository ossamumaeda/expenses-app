const mix = require('laravel-mix');

mix.js('resources/js/dashboard.js', 'public/js')
   .vue() // Remove this line if not using Vue.js
   .postCss('resources/css/app.css', 'public/css', []);

mix.options({
    processCssUrls: false
});