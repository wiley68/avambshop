let mix = require('laravel-mix');

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
   .sass('resources/assets/sass/app.scss', 'public/css');
mix.js('resources/assets/js/profile.js', 'public/js');
mix.js('resources/assets/js/product.js', 'public/js');
mix.js('resources/assets/js/products.js', 'public/js');
mix.js('resources/assets/js/order.js', 'public/js');

mix.styles(
	[
		'resources/assets/css/cart.css'
	], 
	'public/css/cart.css'
);

mix.styles(
	[
		'resources/assets/css/style.css'
	], 
	'public/css/style.css'
);
