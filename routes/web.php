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

Route::group(['middleware' => 'throttle:60,1'], function () {

	Route::get('/', 'HomeController@index');

	// Route::resource('user', 'UserController');
	Auth::routes();
	Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
	Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

	Route::post('/like', 'VideoController@like')->name('video.like');
	Route::post('/save', 'VideoController@save')->name('video.save');
	Route::post('/unsave', 'VideoController@unsave')->name('video.unsave');
	Route::post('/addTags', 'VideoController@addTags')->name('video.addTags');
	Route::post('/removeTags', 'VideoController@removeTags')->name('video.removeTags');

	Route::post('/createComment', 'VideoController@createComment')->name('video.createComment');
	Route::post('/replyComment', 'VideoController@replyComment')->name('video.replyComment');
	Route::post('/deleteComment', 'VideoController@deleteComment')->name('video.deleteComment');
	Route::post('/commentLike', 'VideoController@commentLike')->name('comment.like');
	Route::get('/loadComment', 'VideoController@loadComment')->name('comment.loadComment');

	Route::get('/about', 'HomeController@about');
	Route::get('/contact', 'HomeController@contact');
	Route::get('/terms', 'HomeController@terms');
	Route::get('/policies', 'HomeController@policies');
	Route::get('/copyright', 'HomeController@copyright');
	Route::get('/2257', 'HomeController@p2257');
	Route::get('/video-copyright', 'VideoController@copyright');

	Route::get('/setVideoDuration', 'BotController@setVideoDuration');
	Route::get('/tempMethod', 'BotController@tempMethod');
	Route::get('/comments', 'BotController@comments');
	Route::get('/updateSpankbang', 'BotController@updateSpankbang');
	Route::get('/updateSpankbangErrors', 'BotController@updateSpankbangErrors');
	Route::get('/updateYoujizz', 'BotController@updateYoujizz');
	Route::get('/updateXvideos', 'BotController@updateXvideos');

	Route::get('/uploadRule34', 'BotController@uploadRule34');
	Route::get('/importRule34', 'BotController@importRule34');
	Route::get('/translateRule34', 'BotController@translateRule34');
	Route::get('/updateRule34Sd', 'BotController@updateRule34Sd');

	Route::get('/uploadCosplayjav', 'BotController@uploadCosplayjav');
	Route::get('/translateCosplayjav', 'BotController@translateCosplayjav');

	Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
	Route::get('/user/{user}/upload', 'UserController@userEditUpload')->name('user.userEditUpload');
	Route::post('/user/{user}/userUpdateUpload', 'UserController@userUpdateUpload')->name('user.userUpdateUpload');

	Route::get('/watch', 'VideoController@watch')->name('video.watch');
	Route::get('/download', 'VideoController@download')->name('video.download');
	Route::get('/list', 'HomeController@list')->name('home.list');
	Route::get('/search', ['as' => 'home.search', 'uses' => 'HomeController@search']);

});