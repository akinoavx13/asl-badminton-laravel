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

elixir(function(mix) {
 mix.styles([
  'bootstrap.css',
  'font-awesome/css/font-awesome.css',
  'sweetalert.css',
  'animate.css',
  'style.css',
  'plugins/chosen/chosen.css'
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
  'plugins/chosen/chosen.jquery.js'
 ], 'public/js/app.min.js')
});