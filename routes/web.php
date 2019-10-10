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

Route::get('/', 'BlogController@genreIndex');

Route::get('/contact', 'BlogController@contact');
Route::get('/trending', 'BlogController@trending')->name('video.trending');
Route::get('/watch', 'BlogController@watch')->name('video.watch');
Route::get('/search', ['as' => 'blog.search', 'uses' => 'BlogController@search']);

Route::get('{genre}', 'BlogController@genreIndex')->name('blog.genre.index');
Route::get('{genre}/{category}', 'BlogController@categoryIndex')->name('blog.category.index');
Route::get('{genre}/{category}/{blog}', 'BlogController@show')->name('blog.show');

Route::get('/policy', 'BlogController@policy');
Route::post('/sendMail/{status}', 'BlogController@sendMail');

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');