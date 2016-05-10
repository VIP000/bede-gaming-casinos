var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
        // Scss Styles
        .sass('app.scss')

        // Scripts
        .browserify('app.js')

        // Bootstrap fonts
        .copy('node_modules/bootstrap-sass/assets/fonts', elixir.config.publicPath + '/fonts')

        // Font Awesome fonts
        .copy('node_modules/font-awesome/fonts', elixir.config.publicPath + '/fonts')

        // Copy any fonts
        .copy(elixir.config.publicPath + '/fonts', elixir.config.publicPath + '/build/fonts')

        // Copy any Images
        .copy(elixir.config.assetsPath + '/images', elixir.config.publicPath + '/images')
        .copy(elixir.config.assetsPath + '/images', elixir.config.publicPath + '/build/images')

        // Version the files for cache busting
        .version([
            'js/app.js',
            'css/app.css'
        ]);
});
