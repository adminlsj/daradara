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

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');

Route::resource('order', 'OrderController');
Route::post('/orders/{order}/checkout', ['as' => 'order.checkout', 'uses' => 'OrderController@checkout']);
Route::get('/orders/search', ['as' => 'order.search', 'uses' => 'OrderController@search']);
Route::resource('order.comment', 'CommentController', ['only' => ['store', 'destroy']]);

Route::group(['prefix' => '/orders/{order}/'], function () {
    Route::get('cancel', 'OrderController@cancel');
});


Route::resource('tran', 'TranController');

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