const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/welcome.js', 'public/js')
   .js('resources/js/room.js', 'public/js')
   .js('resources/js/queue.js', 'public/js')
   .js('resources/js/auth-utils.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/welcome.scss', 'public/css')
   .sass('resources/sass/room.scss', 'public/css')
   .version();
