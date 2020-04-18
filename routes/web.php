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

Route::get('/videoDurationEdit', 'HomeController@videoDurationEdit');
Route::get('/videoDurationUpdate', 'HomeController@videoDurationUpdate');

Route::get('/', 'HomeController@index');

Route::resource('blog', 'BlogController');

Auth::routes();
Route::resource('user', 'UserController');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');

Route::get('/tempMethods', 'HomeController@tempMethods');

<<<<<<< HEAD
Route::get('/subscribes', 'VideoController@subscribeIndex')->name('video.subscribes');
Route::post('/subscribe', 'VideoController@subscribe')->name('video.subscribe');
Route::post('/unsubscribe', 'VideoController@unsubscribe')->name('video.unsubscribe');
Route::get('/tag', 'VideoController@subscribeTag')->name('video.subscribeTag');
=======
Route::get('/subscribes', 'SubscribeController@index')->name('subscribe.index');
Route::post('/subscribe', 'SubscribeController@store')->name('subscribe.store');
Route::post('/unsubscribe', 'SubscribeController@destroy')->name('subscribe.destroy');
Route::get('/tag', 'SubscribeControlller@tag')->name('subscribe.tag');
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

Route::post('/like', 'VideoController@like')->name('video.like');
Route::post('/unlike', 'VideoController@unlike')->name('video.unlike');

Route::post('/save', 'VideoController@save')->name('video.save');
Route::post('/unsave', 'VideoController@unsave')->name('video.unsave');

Route::post('/createComment', 'VideoController@createComment')->name('video.createComment');
Route::post('/deleteComment', 'VideoController@deleteComment')->name('video.deleteComment');

<<<<<<< HEAD
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
=======
Route::get('/about-us', 'HomeController@aboutUs');
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
Route::get('/terms', 'HomeController@terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/copyright', 'HomeController@copyright');
Route::get('/check', 'HomeController@check');
Route::get('/checkSubscribes', 'HomeController@checkSubscribes');
Route::get('/checkZeroSubscribes', 'HomeController@checkZeroSubscribes');
Route::get('/bccToSrt', 'HomeController@bccToSrt');
Route::get('/categoryEdit', 'HomeController@categoryEdit')->name('category.edit');
Route::post('/categoryUpdate', 'HomeController@categoryUpdate')->name('category.update');
Route::get('/singleNewCreate', 'HomeController@singleNewCreate')->name('single.create');
Route::post('/singleNewStore', 'HomeController@singleNewStore')->name('single.store');
Route::get('/sitemap.xml', 'HomeController@sitemap');
Route::get('/getSource', 'VideoController@getSource');
Route::get('/createGetSource', 'VideoController@createGetSource');
<<<<<<< HEAD
Route::get('/loadPlaylist', 'VideoController@loadPlaylist')->name('video.loadPlaylist');
Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
Route::get('/userStartUpload', 'UserController@userStartUpload')->name('email.userStartUpload');
Route::get('/user/{user}/upload', 'UserController@userEditUpload')->name('user.userEditUpload');
Route::post('/user/{user}/userUpdateUpload', 'UserController@userUpdateUpload')->name('user.userUpdateUpload');
Route::get('/user/{user}/{genre?}', 'UserController@show')->name('user.show');
=======
Route::get('/loadRelated', 'VideoController@loadRelated');
Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
Route::get('/userStartUpload', 'UserController@userStartUpload')->name('email.userStartUpload');
Route::get('/user/{user}/upload', 'UserController@userEditUpload')->name('user.userEditUpload');
Route::post('/user/{user}/playlist/store', 'PlaylistController@store')->name('playlist.store');
Route::post('/user/{user}/video/store', 'VideoController@store')->name('video.store');

>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

Route::get('/copyrightReport', 'HomeController@copyrightReport')->name('email.copyrightReport');

Route::get('/trending', 'VideoController@watch')->name('video.trending');

<<<<<<< HEAD
Route::get('/rank', 'VideoController@explore')->name('video.rank');
Route::get('/newest', 'VideoController@explore')->name('video.newest');
Route::get('/playlist', 'VideoController@playlist')->name('video.playlist');
Route::get('/{genre}/{title}', 'VideoController@intro')->name('video.intro');

Route::get('/watch', 'VideoController@watch')->name('video.watch');
Route::get('/search', ['as' => 'video.search', 'uses' => 'VideoController@search']);
=======
Route::get('/rank', 'VideoController@index')->name('video.rank');
Route::get('/newest', 'VideoController@index')->name('video.newest');
Route::get('/playlist', 'PlaylistController@show')->name('playlist.show');
Route::get('/{genre}/{title}', 'VideoController@intro');

Route::get('/watch', 'VideoController@show')->name('video.show');
Route::get('/search', 'HomeController@search')->name('home.search');
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
Route::get('/search-google', ['as' => 'video.searchGoogle', 'uses' => 'VideoController@searchGoogle']);