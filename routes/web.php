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

Route::get('/', 'HomeController@index');
Route::get('/database', 'DatabaseController@index')->name('database.index');
Route::get('/database/{table}', 'DatabaseController@show')->name('database.show');
Route::get('/database/{table}/{id}/edit', 'DatabaseController@edit')->name('database.edit');
Route::post('/database/{table}/{id}/update', 'DatabaseController@update')->name('database.update');
Route::get('/analytics', 'DatabaseController@analytics')->name('database.analytics');
Route::get('/analytics/{genre}', 'DatabaseController@genre')->name('database.genre');

Auth::routes();
Route::resource('user', 'UserController');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');

Route::get('/tempMethod', 'HomeController@tempMethod');
Route::get('/setExcludedIds', 'HomeController@setExcludedIds');

Route::post('/like', 'VideoController@like')->name('video.like');
Route::post('/save', 'VideoController@save')->name('video.save');

Route::post('/commentLike', 'VideoController@commentLike')->name('comment.like');
Route::post('/commentUnlike', 'VideoController@commentUnlike')->name('comment.unlike');

Route::post('/createComment', 'VideoController@createComment')->name('video.createComment');
Route::post('/deleteComment', 'VideoController@deleteComment')->name('video.deleteComment');

Route::post('/createFeedback', 'HomeController@createFeedback')->name('home.createFeedback');

Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::get('/terms', 'HomeController@terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/copyright', 'HomeController@copyright');
Route::get('/2257', 'HomeController@p2257');
Route::get('/video-copyright', 'VideoController@copyright');
Route::get('/checkSubscribes', 'HomeController@checkSubscribes');
Route::get('/checkZeroSubscribes', 'HomeController@checkZeroSubscribes');
Route::get('/bccToSrt', 'HomeController@bccToSrt');
Route::get('/categoryEdit', 'HomeController@categoryEdit')->name('category.edit');
Route::post('/categoryUpdate', 'HomeController@categoryUpdate')->name('category.update');
Route::get('/singleNewCreate', 'HomeController@singleNewCreate')->name('single.create');
Route::post('/singleNewStore', 'HomeController@singleNewStore')->name('single.store');
// Route::get('/sitemap.xml', 'HomeController@sitemap');
Route::get('/createGetSource', 'VideoController@createGetSource');
Route::get('/loadPlaylist', 'VideoController@loadPlaylist')->name('video.loadPlaylist');
Route::get('/loadTagList', 'VideoController@loadTagList');
Route::get('/updateHentai', 'HomeController@updateHentai');
Route::get('/updateYoujizz', 'BotController@updateYoujizz');
Route::get('/updateSpankbang', 'BotController@updateSpankbang');
Route::get('/updateSlutload', 'HomeController@updateSlutload');

Route::get('/loadHomeTagList', 'HomeController@loadHomeTagList');
Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
Route::get('/userStartUpload', 'UserController@userStartUpload')->name('email.userStartUpload');
Route::get('/user/{user}/upload', 'UserController@userEditUpload')->name('user.userEditUpload');
Route::post('/user/{user}/userUpdateUpload', 'UserController@userUpdateUpload')->name('user.userUpdateUpload');
Route::get('/user/{user}/{genre?}', 'UserController@show')->name('user.show');

Route::get('/watch', 'VideoController@watch')->name('video.watch');
Route::get('/list', 'HomeController@list')->name('home.list');
Route::get('/search', ['as' => 'home.search', 'uses' => 'HomeController@search']);