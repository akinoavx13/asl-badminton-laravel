var elixir = require('laravel-elixir');

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

elixir(function (mix) {
    mix.sass('app.scss');
});

//.scripts([
//    'libs/bootstrap.min.js',
//    'libs/inspinia.js',
//    'libs/jquery.metisMenu.js',
//    'libs/jquery.slimscroll.min.js',
//    'libs/jquery-2.1.1.js',
//    'libs/jquery-ui.min.js',
//    'libs/laravel.js',
//    'libs/pace.min.js',
//    'libs/sweetalert-dev.js'
//], './public/js/libs.js')
//    .styles([
//        'libs/animate.css',
//        'libs/bootstrap.min.css',
//        'libs/font-awesome.min.css',
//        'libs/sweetalert.css'
//    ], './public/css/libs.css')