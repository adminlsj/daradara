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
Route::get('/anime/{anime}/{title?}', 'AnimeController@show')->name('anime.show');

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::resource('user', 'UserController')->only(['edit', 'update']);

Route::get('/tempMethod', 'BotController@tempMethod');

Route::group(['middleware' => 'admin'], function () {
	// Route::get('/tempMethod', 'BotController@tempMethod');
});