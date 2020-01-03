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

Route::get('/', 'VideoController@home');

Route::resource('blog', 'BlogController');

Route::get('/about-us', 'HomeController@aboutUs');
Route::get('/policy', 'HomeController@policy');
Route::get('/sitemap.xml', 'HomeController@sitemap');

Route::get('/trending', 'VideoController@watch')->name('video.trending');

Route::get('/rank', 'VideoController@rank')->name('video.rank');
Route::get('/variety', 'VideoController@genre')->name('video.variety');
Route::get('/drama', 'VideoController@genre')->name('video.drama');
Route::get('/anime', 'VideoController@genre')->name('video.anime');
Route::get('/{genre}/{title}', 'VideoController@intro')->name('video.intro');

Route::get('/watch', 'VideoController@watch')->name('video.watch');
Route::get('/search', ['as' => 'video.search', 'uses' => 'VideoController@search']);

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');