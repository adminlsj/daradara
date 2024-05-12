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
Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/files', 'FileController@index')->name('file.index');
Route::post('/users/{user}/file', 'FileController@store')->name('file.store');
Route::get('/file/{file}/{title?}', 'FileController@show')->name('file.show');
Route::get('/download/{file}/{title?}', 'FileController@show')->name('file.download');

Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::get('/terms', 'HomeController@terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/copyright', 'HomeController@copyright');
Route::get('/2257', 'HomeController@p2257');

Route::resource('user', 'UserController')->only(['edit', 'update']);

Route::group(['middleware' => 'admin'], function () {
	Route::get('/tempMethod', 'BotController@tempMethod');
});