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

Auth::routes();
Route::resource('user', 'UserController');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');

Route::get('/subscribes', 'VideoController@subscribeIndex')->name('video.subscribes');
Route::post('/subscribe', 'VideoController@subscribe')->name('video.subscribe');
Route::post('/unsubscribe', 'VideoController@unsubscribe')->name('video.unsubscribe');

Route::get('/about-us', 'HomeController@aboutUs');
Route::get('/terms', 'HomeController@terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/copyright', 'HomeController@copyright');
Route::get('/check', 'HomeController@check');
Route::get('/checkSubscribes', 'HomeController@checkSubscribes');
Route::get('/categoryEdit', 'HomeController@categoryEdit')->name('category.edit');
Route::post('/categoryUpdate', 'HomeController@categoryUpdate')->name('category.update');
Route::get('/singleNewCreate', 'HomeController@singleNewCreate')->name('single.create');
Route::post('/singleNewStore', 'HomeController@singleNewStore')->name('single.store');
Route::get('/sitemap.xml', 'HomeController@sitemap');
Route::get('/getSource', 'VideoController@getSource');
Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
Route::get('/userUploadVideo', 'HomeController@userUploadVideo')->name('email.userUploadVideo');

Route::get('/trending', 'VideoController@watch')->name('video.trending');

Route::get('/rank', 'VideoController@rank')->name('video.rank');
Route::get('/newest', 'VideoController@newest')->name('video.newest');
Route::get('/variety', 'VideoController@genre')->name('video.variety');
Route::get('/varietyList', 'VideoController@genreList')->name('video.varietyList');
Route::get('/drama', 'VideoController@genre')->name('video.drama');
Route::get('/anime', 'VideoController@genre')->name('video.anime');
Route::get('/{genre}/{title}', 'VideoController@intro')->name('video.intro');

Route::get('/watch', 'VideoController@watch')->name('video.watch');
Route::get('/search', ['as' => 'video.search', 'uses' => 'VideoController@search']);
Route::get('/search-google', ['as' => 'video.searchGoogle', 'uses' => 'VideoController@searchGoogle']);

Route::get('/updateDuration', 'VideoController@updateDuration');