<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@getHome');
Route::get('/about', 'PagesController@getAbout');
Route::get('/contact', 'PagesController@getContact');
Route::get('/request/{id}', 'PagesController@requestProduct')->name('request-product');
Route::post('/request/submit', 'MessagesController@submitRequest');
Route::get('/sitemap', 'PagesController@getSitemap');
Route::get('/profile', 'PagesController@getProfile');
Route::get('/orders', 'PagesController@getOrders')->name('orders');
Route::get('/delete-order{id}', 'WebordersController@deleteOrder')->name('delete-order');
Route::get('/pay-order{id}', 'WebordersController@payOrder')->name('pay-order');
Route::get('/user-order{id}', 'PagesController@getUserOrder')->name('user-order');
Route::get('/terms', 'PagesController@getTerms');
Route::get('/politika', 'PagesController@getPolitika');
Route::get('/dostavka', 'PagesController@getDostavka');
Route::get('/vrashtane', 'PagesController@getVrashtane');
Route::get('/products', 'PagesController@getProducts');
Route::post('/products/search', 'PagesController@getProductsSearch')->name('products.search');
Route::get('/products/by_firm{id}', 'PagesController@getProductsByFirm')->name('products.by_firm');
Route::get('/products/by_category{id}', 'PagesController@getProductsByCategory')->name('products.by_category');
Route::post('/contact/submit', 'MessagesController@submit');
Route::get('/firms', 'PagesController@getFirms');
Route::get('/product', 'PagesController@getProduct');
Route::post('/product/set_session', 'PagesController@setSessionData');
Route::post('/cart/change_cart', 'PagesController@changeSessionData');
Route::post('/profile/save', 'UsersController@saveUser');
Route::get('/cart', 'PagesController@getCart');
Route::get('/order', 'PagesController@getOrder');
Route::post('/order/submit', 'WebordersController@submit');
Route::get('/order/print/{ids}', 'WebordersController@print')->name('order.print');
Route::get('/mailorder', 'PagesController@getEmailsOrder');
Route::get('sendhtmlemail', 'MailController@html_email');

Auth::routes();
