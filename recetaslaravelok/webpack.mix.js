const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
/*
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
 */

mix.js('resources/js/app.js', 'public/js')
// para recargar el pluguin del carrosul owl carousel de jquery, no hay que instalarlo laravel ya los tiene solo cargarlos
//instalar via npm el plugguin del old carrusel de jquery
//ir al app e importarlo para que cargue el archivo de js
.autoload({
    jquery: ['$','window.jQuery', 'jQuery']
})
.sass('resources/sass/app.scss', 'public/css');
