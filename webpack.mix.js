let mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
<<<<<<< HEAD
   .js('resources/assets/js/video.js', 'public/js')
   .js('resources/assets/js/loadMore.js', 'public/js')
   .js('resources/assets/js/customSelect.js', 'public/js')
=======
   .js('resources/assets/js/loadMore.js', 'public/js')
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
   .webpackConfig({
	    plugins: [
	      new CompressionPlugin({
	        filename: '[path].gz[query]',
	        algorithm: 'gzip',
	        test: /\.js$|\.css$|\.html$|\.svg$/,
	        threshold: 10240,
	        minRatio: 0.8,
	      })
	    ]
	});

if (mix.inProduction()) {
    mix.version();
}