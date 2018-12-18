<?php

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

Route::get('/', 'BlogController@index');
Route::resource('blog', 'BlogController');
Route::get('blog/{blog}', 'BlogController@showOnly')->name('blog.show');
Route::get('blog/{category?}/{blog}', 'BlogController@show')->name('blog.category.show');

Route::get('/contact', 'BlogController@contact');
Route::get('/policy', 'BlogController@policy');
Route::post('/sendMail/{status}', 'BlogController@sendMail');

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');