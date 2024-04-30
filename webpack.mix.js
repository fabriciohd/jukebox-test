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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css').sourceMaps();

mix.alias({
    '@': 'resources/js',
    '@api': 'resources/js/api',
    '@components': 'resources/js/components',
    '@pages': 'resources/js/pages',
    '@templates': 'resources/js/templates',
    '@routes': 'resources/js/routes',
});

//mix.browserSync('http://localhost:8000/');

mix.options({
    hmrOptions: {
        host: 'localhost',
        port: 8080,
    }
});

mix.webpackConfig({
    devServer: {
        proxy: {
            '*': 'http://localhost:8000'
        }
    }
});
