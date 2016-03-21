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
    mix.styles([
        'bootstrap.css',
        'font-awesome/css/font-awesome.css',
        'sweetalert.css',
        'animate.css',
        'style.css',
        'plugins/chosen/chosen.css',
        'plugins/dataTables/dataTables.bootstrap.css',
        'plugins/dataTables/dataTables.responsive.css',
        'plugins/dataTables/dataTables.tableTools.min.css',
        'plugins/clockpicker/clockpicker.css',
        'perso.css',
        'plugins/summernote/summernote.css',
        'tabledragdrop.css'
    ], 'public/css/app.min.css');

    mix.scripts([
        'jquery-2.1.1.js',
        'bootstrap.js',
        'inspinia.js',
        'sweetalert-dev.js',
        'plugins/pace/pace.min.js',
        'plugins/jasny/jasny-bootstrap.min.js',
        'plugins/metisMenu/jquery.metisMenu.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
        'plugins/chosen/chosen.jquery.js',
        'plugins/dataTables/jquery.dataTables.js',
        'plugins/dataTables/dataTables.bootstrap.js',
        'plugins/dataTables/dataTables.responsive.js',
        'plugins/dataTables/dataTables.tableTools.min.js',
        'plugins/clockpicker/clockpicker.js',
        'plugins/summernote/summernote.min.js',
        'plugins/peity/jquery.peity.min.js',
        'tabledragdrop.js'
    ], 'public/js/app.min.js')
});