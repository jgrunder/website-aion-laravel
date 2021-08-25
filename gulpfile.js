var elixir = require('laravel-elixir');
var elixirImageMin = require('laravel-elixir-imagemin');

/**
 * Stylesheet
 */
elixir(function(mix) {
    mix.sass('global.scss')
       .styles([
            'bootswatch.min.css',
            'font-awesome.min.css'
       ], 'public/css/admin.css')
       .styles([
            'font-awesome.min.css'
       ], 'public/css/libs.css');
});

/**
 * Scripts
 */
elixir(function(mix) {
    mix.scripts([
        'libs/jquery-2.1.4.min.js',
        'libs/bootstrap.min.js',
        'script_admin.js'
    ], 'public/js/admin.js');

    mix.scripts([
        'libs/jquery-2.1.4.min.js',
        'libs/jquery.bxslider.min.js',
        'libs/sweetalert.min.js',
        'script.js'
    ], 'public/js/global.js');
});

/**
 * Images
 */
elixir(function(mix) {
    mix.imagemin("./resources/assets/images", "public/images");
})
