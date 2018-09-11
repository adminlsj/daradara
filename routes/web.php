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
Route::get('/manual', 'HomeController@manual');
Route::get('/contact', 'HomeController@contact');
Route::post('/sendMail/{status}', 'HomeController@sendMail');

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');
Route::get('users/{user}/savedJobsIndex', ['as' => 'user.savedJobsIndex', 'uses' => 'UserController@savedJobsIndex']);

Route::resource('job', 'JobController');
Route::post('/jobs/{job}/checkout', ['as' => 'job.checkout', 'uses' => 'JobController@checkout']);
Route::get('/jobs/search', ['as' => 'job.search', 'uses' => 'JobController@search']);
Route::post('/jobs/{job}/select', ['as' => 'job.select', 'uses' => 'JobController@select']);
Route::post('/jobs/{job}/save', ['as' => 'job.save', 'uses' => 'JobController@save']);
Route::post('/jobs/{job}/saveRight', ['as' => 'job.saveRight', 'uses' => 'JobController@saveRight']);
Route::resource('job.comment', 'CommentController', ['only' => ['store', 'destroy']]);

Route::group(['prefix' => '/jobs/{job}/'], function () {
    Route::get('cancel', 'JobController@cancel');
});

Route::resource('app', 'AppController');

Route::resource('resume', 'ResumeController');

Route::resource('blog', 'BlogController');

Route::group(['prefix' => '{folder}/{filename}/'], function () {
	Route::get('getImg', function ($folder, $filename)
	{
		$entry = storage_path('app/'.$folder.'/'.$filename.'.jpg');
		$image = Image::make($entry);
		return $image->response();
	});
	Route::get('getSquareImg', function ($folder, $filename)
	{
		$entry = 'https://s3-us-west-2.amazonaws.com/freerider/'.$folder.'/'.$filename.'.jpg';
		$image = Image::make($entry);

		if ($image->height() <= $image->width()) {
			$image->crop($image->height(), $image->height());
		} else {
			$image->crop($image->width(), $image->width());
		}

		return $image->resize(500, 500)->response();
	});
});