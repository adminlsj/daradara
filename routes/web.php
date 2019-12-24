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

Route::get('/', 'BlogController@home');

Route::get('/contact', 'BlogController@contact');
Route::get('/policy', 'BlogController@policy');
Route::get('/trending', 'BlogController@watch')->name('video.trending');
Route::get('/sitemap.xml', 'BlogController@sitemap');

Route::get('/rank', 'BlogController@rank')->name('video.rank');
Route::get('/variety', 'BlogController@genre')->name('video.variety');
Route::get('/drama', 'BlogController@genre')->name('video.drama');
Route::get('/anime', 'BlogController@genre')->name('video.anime');
Route::get('/{genre}/{title}', 'BlogController@intro')->name('video.intro');

Route::get('/watch', 'BlogController@watch')->name('video.watch');
Route::get('/search', ['as' => 'blog.search', 'uses' => 'BlogController@search']);

Route::get('{genre}', 'BlogController@genreIndex')->name('blog.genre.index');
Route::get('{genre}/{category}', 'BlogController@categoryIndex')->name('blog.category.index');
Route::get('{genre}/{category}/{blog}', 'BlogController@show')->name('blog.show');

Route::post('/sendMail/{status}', 'BlogController@sendMail');

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');