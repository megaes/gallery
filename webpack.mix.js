const { mix } = require('laravel-mix');

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

mix.options({
    extractVueStyles: 'public/css/vue-css.css',
});

mix.webpackConfig({
    resolve: {
        alias: {
            'masonry': 'masonry-layout',
            'isotope': 'isotope-layout'
        }
    }
});

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .combine([
       'public/css/app.css',
       'resources/assets/css/font-awesome.css',
       'node_modules/dropzone/dist/dropzone.css',
       'public/css/vue-css.css'
   ], 'public/css/all.css');


if (mix.config.inProduction) {
    mix.version();
}