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

elixir.config.sourcemaps = false;

elixir(function(mix) {
    
    mix.copy('resources/assets/unify-1.9.4/', 'public/assets');
    mix.copy('resources/assets/bower_components/AdminLTE/dist', 'public/assets/plugins/adminlte/dist')
        .copy('resources/assets/bower_components/AdminLTE/plugins', 'public/assets/plugins/adminlte/plugins')
        .copy('resources/assets/bower_components/bootstrap3-typeahead', 'public/assets/plugins/bootstrap3-typeahead');

    mix.sass('app.scss', 'public/assets/css/custom.css')
        .sass('print.scss', 'public/assets/css/print.css');
});
